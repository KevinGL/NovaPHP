<?php

namespace Src\Controllers;

class AbstractController
{
    protected function prism(string $path, array $params = [])
    {
        $totalPath = __DIR__ . "/../../app/View/" . $path;
        
        $content = file_get_contents($totalPath);

        $words = explode(" ", $content);

        foreach($params as $key => $value)
        {
            $key = "%" . $key;
            $words = str_replace($key, $value, $words);
        }

        for($i = 0 ; $i < count($words) ; $i++)
        {
            if(str_starts_with($words[$i], "%"))
            {
                $words[$i] = "UNDEFINED";
            }
        }

        echo implode(' ', $words);
    }
}