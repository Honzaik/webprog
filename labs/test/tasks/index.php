<?php

    // Example of input data
    $tasks = [
        (object)[
            'id' => 't1',
            'task' => 'Smash the anvil',
            'assigned' => 'Thor',
            'parent' => null,
        ],
        (object)[
            'id' => 't2',
            'task' => 'Keep the door closed',
            'assigned' => 'Heimdall',
            'parent' => null,
        ],
        (object)[
            'id' => 't2.1',
            'task' => 'Find the key and lock it',
            'assigned' => 'Freyr',
            'parent' => 't2',
        ],
        (object)[
            'id' => 't3',
            'task' => 'Rule the Asgard',
            'assigned' => 'Odin',
            'parent' => null,
        ],
    ];

    // If data file is present in current directory, load $tasks data from that file.
    $inputFile = './tasks.json';
    if (is_readable($inputFile) && is_file($inputFile)) {
        $json = file_get_contents($inputFile);
        $tasks = json_decode($json, false);
    }

    /*
     * Your PHP code goes here
     * (and you may modify HTML-interleaved code below)
     */
     function printChildren(array $tasks, string $parent): string
     {
         $result = '<ul>' . PHP_EOL;
         
         $matchingTasks = 0;
         
        foreach ($tasks as $task) {
            if ((string)$task->parent === $parent) {
                $result .= '<li>' . htmlspecialchars($task->id) . '-' . htmlspecialchars($task->task) . '-' . htmlspecialchars($task->assigned);
                $result .= PHP_EOL . printChildren($tasks, $task->id);
                $result .= '</li>' . PHP_EOL;
                $matchingTasks++;
            }
        }
        
        $result .= '</ul>';
         
         if ($matchingTasks === 0) {
             $result = '';
         }
         
         return $result;
     }



?><!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Project Planner</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
</head>

<body class="container">
<h1 class="mt-4 mb-4">Project Planner</h1>

<?= printChildren($tasks, '') ?>

</body>

</html>
