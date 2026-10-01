<?php

namespace Src\Controllers;

class AbstractController
{
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
}