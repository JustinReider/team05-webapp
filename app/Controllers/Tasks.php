<?php

namespace App\Controllers;

use App\Models\TasksModel;

class Tasks extends BaseController
{
    public function getIndex()
    {
        $model = new TasksModel();
        $allTasks = $model->getTasks();

        foreach ($allTasks as $task) {
            $spalteId = $task['spaltenid'];
            if (!isset($tasksBySpalte[$spalteId])) {
                $tasksBySpalte[$spalteId] = [];
            }
            $tasksBySpalte[$spalteId][] = $task;
        }

        return view('pages/tasks', ['tasks' => $tasksBySpalte]);
    }
}
