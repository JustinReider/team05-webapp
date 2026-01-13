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

	public function getNew()
	{
		$model = new TasksModel();
		$data['title'] = 'Neue Task erstellen';
		$data['task'] = null;
		return view('pages/tasks_form', $data);
	}

	public function postSave()
	{
		$model = new TasksModel();
		$saveData = [
			'tasks'            => $this->request->getPost('tasks'),
			'taskartenid'      => $this->request->getPost('taskartenid'),
			'personenid'       => $this->request->getPost('personenid'),
			'spaltenid'        => $this->request->getPost('spaltenid'),
			'erinnerungsdatum' => $this->request->getPost('erinnerungsdatum'),
			'notiz'            => $this->request->getPost('notiz'),
			'erinnerung'       => $this->request->getPost('erinnerung'),
			'erledigt'         => 0,
			'geloescht'        => 0
		];

		$model->insert($saveData);
		return redirect()->to(base_url('tasks'));
	}
}
