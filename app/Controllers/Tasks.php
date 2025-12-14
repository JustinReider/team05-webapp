<?php

namespace App\Controllers;

use App\Models\TasksModel;

class Tasks extends BaseController
{
	public function getIndex()
	{
		$model = new TasksModel();
		$data['tasks'] = $model->getData();
		
		return view('pages/personen', $data);
	}
}
