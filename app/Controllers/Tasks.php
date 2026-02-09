<?php

namespace App\Controllers;

use App\Models\TasksModel;
use App\Models\BoardsModel;
use App\Models\SpaltenModel;
use App\Models\TaskartenModel;
use App\Models\PersonenModel;

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
		$data['title'] = 'Neue Task erstellen';
		$data['task'] = null;
		$data['spalten'] = new SpaltenModel()->getSpaltenWithBoards();
		$data['taskarten'] = new TaskartenModel()->getTaskarten();

		$data['personen'] = (new PersonenModel())->getData();
		$data['task_personen_ids'] = [];

		return view('tasks/task_form', $data);
	}

	public function getEdit($id)
	{
		$model = new TasksModel();
		$task = $model->getTask($id);
		$board = $model->getBoardByTask($id);

		if (empty($task)) {
			return redirect()->to(base_url() . '/tasks');
		}
		$data['title'] = 'Task bearbeiten';
		$data['task'] = $task;
		$data['spalten'] = new SpaltenModel()->getSpaltenByBoard($board);
		$data['taskarten'] = new TaskartenModel()->getTaskarten();

		$data['personen'] = (new PersonenModel())->getData();
		$data['task_personen_ids'] = [];

		return view('tasks/task_form', $data);
	}

	public function postSave($id = null)
	{
		$validation = \Config\Services::validation();

		if (!$validation->run($_POST, 'tasksbearbeiten')) {
			return $this->renderForm($id, $validation);
		}

		$saveData = $this->getTaskDataFromPost();
		$personenids = $this->request->getPost('personenids') ?? [];
		$model = new TasksModel();

		if ($this->executeSave($model, $id, $saveData, $personenids)) {
			return redirect()->to(base_url('tasks'))->with('success', 'Gespeichert.');
		}

		return redirect()->back()->withInput()->with('error', 'Fehler beim Speichern.');
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

	public function postToggleDone($id)
	{
		$model = new TasksModel();
		$task = $model->find($id);
		if (empty($task)) {
			return $this->response->setStatusCode(404)->setBody('Task nicht gefunden');
		}
		$newStatus = $task['erledigt'] ? 0 : 1;
		$model->update($id, ['erledigt' => $newStatus]);
		return redirect()->to(base_url('tasks'));
	}

	private function renderForm($id, $validation)
	{
		$tasksModel = new TasksModel();
		$task = $this->request->getPost();
		if (!empty($id)) $task['id'] = $id;

		$task_personen_ids = $this->request->getPost('personenids') ?? [];

		if (empty($this->request->getPost()) && !empty($id)) {
			$personenTasksModel = new \App\Models\PersonenTasksModel();
			$task_personen_ids = array_column(
				$personenTasksModel->where('tasksid', $id)->findAll(),
				'personenid'
			);
		}

		$data = [
			'validation'        => $validation,
			'title'             => empty($id) ? 'Neue Task erstellen' : 'Task bearbeiten',
			'task'              => $task,
			'task_personen_ids' => $task_personen_ids,
			'personen'          => (new \App\Models\PersonenModel())->getData(),
			'taskarten'         => (new TaskartenModel())->getTaskarten(),
			'origin'            => base_url('tasks'),
			'spalten'           => empty($id)
				? (new SpaltenModel())->getSpaltenWithBoards()
				: (new SpaltenModel())->getSpaltenByBoard($tasksModel->getBoardByTask($id))
		];

		return view('tasks/task_form', $data);
	}

	private function getTaskDataFromPost()
	{
		return [
			'tasks'            => $this->request->getPost('tasks'),
			'taskartenid'      => $this->request->getPost('taskartenid'),
			'spaltenid'        => $this->request->getPost('spaltenid'),
			'sortid'           => $this->request->getPost('sortid'),
			'erinnerungsdatum' => $this->request->getPost('erinnerungsdatum') ?: null,
			'erinnerung'       => $this->request->getPost('erinnerung') ? 1 : 0,
			'notizen'          => $this->request->getPost('notizen'),
			'geloescht'        => 0
		];
	}

	private function executeSave($model, $id, $saveData, $personenids)
	{
		if (empty($id)) {
			if ($model->insert($saveData)) {
				$newId = $model->getInsertID();
				return $model->updateTaskWithPeople($newId, $saveData, $personenids);
			}
			return false;
		}

		return $model->updateTaskWithPeople($id, $saveData, $personenids);
	}
}
