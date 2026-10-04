<?php

namespace Src\Controllers;

class AbstractController
{
    private \PDO $pdo;

    public function __construct()
    {
        $content = file_get_contents(__DIR__ . "/../../.env");
        if($content === "" || !$content)
        {
            echo "Add .env file";
            return;
        }

        $datasEnv = [];

        $lines = explode("\n", $content);

        foreach($lines as $line)
        {
            [$key, $value] = explode("=", $line);
            
            if(str_starts_with($value, "\""))
            {
                $value = substr($value, 1, strlen($value));
            }

            $datasEnv[$key] = $value;
        }

        if(!array_key_exists("DATABASE_URL", $datasEnv))
        {
            echo "Add variable DATABASE_URL in your .env file";
            return;
        }

        $db = parse_url($datasEnv["DATABASE_URL"]);

        $dsn = sprintf(
            "mysql:host=%s;port=%d;dbname=%s;charset=utf8mb4",
            $db['host'],
            $db['port'] ?? 3306,
            ltrim($db['path'], '/')
        );

        $this->pdo = new \PDO($dsn, $db['user'], $db['pass'] ?? '', [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
        ]);
    }

    private function getTableNameFromModel(string $modelClass): string
    {
        $tableName = "";
    
        $pos = strrpos($modelClass, "\\");
        if($pos)
        {
            $tableName = lcfirst(substr($modelClass, $pos + 1));
        }

        return $tableName;
    }

    private function getTypesCol(string $tableName): array
    {
        $stmt = $this->pdo->query("SHOW COLUMNS FROM $tableName");
        $types = $stmt->fetchAll();

        $typesFields = [];

        foreach($types as $type)
        {
            $typesFields[$type["Field"]] = $type["Type"];
        }

        return $typesFields;
    }

    private function getModelProperties(string $modelClass): array
    {
        $reflection = new \ReflectionClass($modelClass);
        $properties = $reflection->getProperties();

        return $properties;
    }

    private function initInstanceFromProps(mixed $instance, array $properties, array $fields, array $typesFields): mixed
    {
        foreach ($properties as $property)
        {
            $name = $property->getName();
            $setter = "set" . ucfirst($name);
            $fieldDB = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $name));

            $value = $fields[$fieldDB];
            $type = $typesFields[$fieldDB];
            
            if($type === "date" || $type === "date_time")
            {
                $time = strtotime($value);
                $value = new \DateTimeImmutable();
                $value = $value->setTimezone(new \DateTimeZone("Europe/Paris"));
                $value = $value->setTimestamp($time);
            }

            $instance->$setter($value);
        }

        return $instance;
    }

    protected function render(string $path, array $params = [])
    {
        $totalPath = __DIR__ . "/../../app/View/" . $path;

        if (!file_exists($totalPath))
        {
            throw new \Exception("La vue $path n'existe pas.");
        }

        $content = file_get_contents($totalPath);

        $contentConverted = "<?php\n";

        //Injection variables
        foreach ($params as $key => $value)
        {
            $contentConverted .= "    $" . $key . " = " . var_export($value, true) . ";\n";
        }

        $contentConverted .= "?>\n" . $content;
    
        $contentConverted = str_replace("{{", "<?= htmlspecialchars(", $contentConverted);
        $contentConverted = str_replace("}}", ")?>", $contentConverted);

        $contentConverted = preg_replace('/\@if\s*\((.*?)\)/', '<?php if ($1): ?>', $contentConverted);
        $contentConverted = preg_replace('/\@elseif\s*\((.*?)\)/', '<?php elseif ($1): ?>', $contentConverted);
        $contentConverted = preg_replace('/\@else\s*/', '<?php else: ?>', $contentConverted);
        $contentConverted = preg_replace('/\@endif\s*/', '<?php endif; ?>', $contentConverted);

        $contentConverted = preg_replace('/\@foreach\s*\((.*?)\)/', '<?php foreach ($1): ?>', $contentConverted);
        $contentConverted = preg_replace('/\@endforeach\b/', '<?php endforeach; ?>', $contentConverted);

        $pathCache = __DIR__ . "/../../app/Core/Templating/cache/temp.php";

        file_put_contents($pathCache, $contentConverted);

        require_once $pathCache;

        unlink($pathCache);
    }

    protected function find(string $modelClass, int $id): mixed
    {
        $tableName = $this->getTableNameFromModel($modelClass);
    
        $stmt = $this->pdo->prepare("SELECT * FROM $tableName WHERE id=:id");
        $stmt->execute(['id' => $id]);
        $fields = $stmt->fetch();

        $typesFields = $this->getTypesCol($tableName);
        $properties = $this->getModelProperties($modelClass);

        $instance = new $modelClass;

        $instance = $this->initInstanceFromProps($instance, $properties, $fields, $typesFields);

        return $instance;
    }

    protected function findAll(string $modelClass): array
    {
        $tableName = $this->getTableNameFromModel($modelClass);
    
        $stmt = $this->pdo->query("SELECT * FROM $tableName");
        $res = $stmt->fetchAll();

        $typesFields = $this->getTypesCol($tableName);
        $properties = $this->getModelProperties($modelClass);

        $datas = [];

        foreach($res as $r)
        {
            $instance = new $modelClass;
            $instance = $this->initInstanceFromProps($instance, $properties, $r, $typesFields);

            array_push($datas, $instance);
        }

        return $datas;
    }
}