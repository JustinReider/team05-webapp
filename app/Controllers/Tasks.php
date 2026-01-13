<?php

namespace App\Controllers;

use App\Models\TasksModel;

class Tasks extends BaseController
{
	public function getIndex()
	{
		$model = new TasksModel();
		$data['personen'] = $model->getData();
		return view('pages/personen', $data);
	}

	public function getTasks()
	{
		$model = new TasksModel();
		$tasks['tasks'] = $model->getTasks();
		return view('pages/tasks', $tasks);
	}
}
