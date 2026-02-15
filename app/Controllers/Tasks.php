<?php

namespace App\Controllers;

use App\Models\TasksModel;
use App\Models\BoardsModel;
use App\Models\SpaltenModel;
use App\Models\TaskartenModel;
use App\Models\PersonenModel;

class Tasks extends BaseController
{
	private const VIEW_TASK_FORM = 'tasks/task_form';
	private const VIEW_TASKS_PAGE = 'tasks/tasks';
	public function getIndex(): string
	{
		$tm = new \App\Models\TasksModel();
		$bm = new \App\Models\BoardsModel();

		$board = $this->request->getGet('board');
		if (!ctype_digit($board)) {
			$board = 1;
		}

		$data['tasks'] = $tm->getColumnsTasks($board);
		$data['boardName'] = $bm->getBoardName($board)['board'];
		$data['boards'] = $bm->getBoards();

		return view(self::VIEW_TASKS_PAGE, $data);
	}

	public function getNew(): string
	{
		return $this->renderForm(null);
	}

	public function getEdit(int $id)
	{
		return $this->renderForm($id);
	}

	public function postSave($id = null)
	{
		$validation = \Config\Services::validation();

		if (!$validation->run($_POST, 'tasksbearbeiten')) {
			return $this->renderForm($id, $validation);
		}

		$data = $this->getTaskDataFromPost();
		$saveData = $data['taskData'];
		$personenids = $data['personenids'];
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

	public function postUpdatePosition()
	{
		$json = $this->request->getJSON();
		$taskId = $json->taskId;
		$newSpaltenId = $json->newSpaltenId;
		$positions = $json->positions;

		$model = new TasksModel();

		// Spalte der verschobenen Task aktualisieren
		$model->update($taskId, ['spaltenid' => $newSpaltenId]);

		// Sortierreihenfolge aller Tasks in der Zielspalte aktualisieren
		foreach ($positions as $index => $id) {
			$model->update($id, ['sortid' => $index + 1]);
		}

		return $this->response->setJSON(['success' => true]);
	}

	/**
	 * Render the task form with validation and pre-filled data.
	 * @param int|null $id Task ID or null for new
	 * @param \CodeIgniter\Validation\Validation $validation Validation object
	 * @return string Rendered view
	 */
	private function renderForm($id, $validation = null): string
	{
		$model = new \App\Models\TasksModel();
		$postData = $this->request->getPost();
		$task = !empty($postData) ? $postData : $model->getTask($id);
		$task['id'] = !empty($id) ? $id : null;
		$board = !empty($id) ? $model->getBoardByTask($id) : null;

		$task_personen_ids = $this->getTaskPersonenIds($id);

		$data = [
			'validation' => $validation,
			'title' => empty($id) ? 'Neue Task erstellen' : 'Task bearbeiten',
			'task' => $task,
			'task_personen_ids' => $task_personen_ids,
			'personen' => (new \App\Models\PersonenModel())->getData(),
			'taskarten' => (new \App\Models\TaskartenModel())->getTaskarten(),
			'origin' => !empty($postData) ? base_url('tasks') : null,
			'spalten' => empty($id)
				? (new \App\Models\SpaltenModel())->getSpaltenWithBoards()
				: (new \App\Models\SpaltenModel())->getSpaltenByBoard($board)
		];

		return view(self::VIEW_TASK_FORM, $data);
	}

	/**
	 * Extract task data from POST request for saving.
	 * @return array Task data
	 */
	private function getTaskDataFromPost(): array
	{
		return [
			'taskData' => [
				'tasks' => $this->request->getPost('tasks'),
				'taskartenid' => $this->request->getPost('taskartenid'),
				'spaltenid' => $this->request->getPost('spaltenid'),
				'sortid' => $this->request->getPost('sortid'),
				'erinnerungsdatum' => $this->request->getPost('erinnerungsdatum') ?: null,
				'erinnerung' => $this->request->getPost('erinnerung') ? 1 : 0,
				'notizen' => $this->request->getPost('notizen'),
				'geloescht' => 0
			],
			'personenids' => $this->request->getPost('personenids') ?? []
		];
	}

	/**
	 * Insert or update a task and assign people.
	 * @param \App\Models\TasksModel $model
	 * @param int|null $id Task ID or null for new
	 * @param array $saveData Task data
	 * @param array $personenids IDs of assigned people
	 * @return bool Success
	 */
	private function executeSave(\App\Models\TasksModel $model, ?int $id, array $saveData, array $personenids): bool
	{
		if (empty($id)) {
			if ($model->insert($saveData)) {
				$newId = $model->getInsertID();
				return $model->updateTaskWithPeople($newId, $saveData, $personenids);
			}
			return false;
		} else {
			return $model->updateTaskWithPeople($id, $saveData, $personenids);
		}
	}

	/**
	 * Prepare data for task form (new/edit)
	 * @param int|null $boardId
	 * @return array
	 */
	private function prepareTaskFormData(?int $boardId = null): array
	{
		return [
			'spalten' => $boardId === null
				? (new \App\Models\SpaltenModel())->getSpaltenWithBoards()
				: (new \App\Models\SpaltenModel())->getSpaltenByBoard($boardId),
			'taskarten' => (new \App\Models\TaskartenModel())->getTaskarten(),
			'personen' => (new \App\Models\PersonenModel())->getData(),
		];
	}

	/**
	 * Get assigned person IDs for a task.
	 * @param int|null $taskId
	 * @return array
	 */
	private function getTaskPersonenIds(?int $taskId): array
	{
		if (empty($taskId)) {
			return [];
		}
		$personenTasksModel = new \App\Models\PersonenTasksModel();
		return array_column(
			$personenTasksModel->where('tasksid', $taskId)->findAll(),
			'personenid'
		);
	}
}
