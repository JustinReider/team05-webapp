<?php

namespace App\Controllers;

use App\Models\TasksModel;

class Tasks extends BaseController
{
	public function getIndex()
	{
		$model = new TasksModel();
		$tasks['tasks'] = $model->getTasks();
		return view('pages/tasks', $tasks);
	}
	public function getNew()
	{
    $model = new TasksModel();
	$data['title'] = 'Neue Task erstellen';
	$data['task'] = null;
	return view(pages/tasks_form', $data);
	}
}
