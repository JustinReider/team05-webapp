<?php

namespace App\Controllers;

use App\Models\TasksModel;
use App\Models\BoardsModel;

class Tasks extends BaseController
{
	public function getIndex()
	{
		$tm = new TasksModel();
		$bm = new BoardsModel();

		$board = $this->request->getGet('board');
		if (!ctype_digit($board)) {
			$board = 1;
		}

		$data['tasks'] = $tm->getColumnsTasks($board);

		$data['boardName'] = $bm->getBoardName($board)['board'];
		
		return view('pages/tasks', $data);
	}

	public function getNew()
	{
		$model = new TasksModel();
		$data['title'] = 'Neue Task erstellen';
		$data['task'] = null;
		return view('tasks/new', $data);
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
