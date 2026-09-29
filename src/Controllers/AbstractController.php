<?php

namespace Src\Controllers;

class AbstractController
{
    protected function prism(string $path, array $params = [])
    {
        $totalPath = __DIR__ . "/../../app/View/" . $path;

        if (!file_exists($totalPath))
        {
            throw new \Exception("La vue $path n'existe pas.");
        }

        $content = file_get_contents($totalPath);

        foreach ($params as $key => $value)
        {
            $content = str_replace('%' . $key, htmlspecialchars((string) $value), $content);
        }

        $content = preg_replace('/%[a-zA-Z0-9_]+/', 'UNDEFINED', $content);

        echo $content;
    }
}