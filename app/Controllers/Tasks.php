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
		$data['boards'] = $bm->getBoards();

		return view('pages/tasks', $data);
	}

	public function getNew()
	{
		$model = new TasksModel();
		$data['title'] = 'Neue Task erstellen';
		$data['task'] = null;
		$data['todo'] = 0;
		return view('tasks/new', $data);
	}

	public function getEdit($id)
	{
		$model = new TasksModel();
		$task = $model->getTask($id);

		if (empty($task)) {
			return redirect()->to(base_url() . '/tasks');
		}
		$data['title'] = 'Task bearbeiten';
		$data['task'] = $task;
		$data['todo'] = 1;
		return view('tasks/update', $data);
	}


	public function getDelete($id)
	{
		$model = new TasksModel();
		$task = $model->getTasks($id);

		if (empty($task)) {
			return redirect()->to(base_url() . '/tasks');
		}

		$data['title'] = 'Task löschen';
		$data['task'] = $task;
		$data['todo'] = 2;
		return view('tasks/new', $data);
	}

	public function postSave($id = null)
	{
		$model = new TasksModel();
		$saveData = [
			'tasks'            => $this->request->getPost('tasks'),
			'taskartenid'      => $this->request->getPost('taskartenid'),
			'spaltenid'        => $this->request->getPost('spaltenid'),
			'sortid'           => $this->request->getPost('sortid'),
			'erinnerungsdatum' => $this->request->getPost('erinnerungsdatum') ?: null,
			'erinnerung'       => $this->request->getPost('erinnerung') ? 1 : 0,
			'notizen'            => $this->request->getPost('notizen'),
			'erledigt'         => 0,
			'geloescht'        => 0
		];
		if (empty($id)) {
			if (!$model->insert($saveData)) {
				// Show errors for debugging
				return $this->response->setStatusCode(400)->setBody('Insert failed: ' . print_r($model->errors(), true));
			}
			return redirect()->to(base_url('tasks'));
		} else {
			// UPDATE - Task aktualisieren
			if ($model->update($id, $saveData)) {
				return redirect()->to(base_url('/tasks'));
			} else {
				return redirect()->back()
					->withInput()->with('error', 'Fehler beim Aktualisieren der Task!');
			}
		}
	}

	public function postDelete($id)
	{
		$model = new TasksModel();

		if (!empty($id)) {
			if ($model->delete($id)) {
				return redirect()->to(base_url('tasks'))
					->with('success', 'Task wurde erfolgreich gelöscht!');
			} else {
				return redirect()->to(base_url('tasks'))
					->with('error', 'Fehler beim Löschen der Task!');
			}
		}

		return redirect()->to(base_url('tasks'))
			->with('error', 'Keine Task-ID angegeben!');
	}
}
