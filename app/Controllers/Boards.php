<?php

namespace App\Controllers;

use App\Models\BoardsModel;

class Boards extends BaseController
{
	public function getIndex(): string
	{
		$model = new BoardsModel();

		$data = [
			'boards' => $model->getBoards(),
		];

		return view('boards/boards', $data);
	}

	public function getNew(): string
	{
		$data['title'] = 'Neues Board erstellen';
		$data['board'] = null;
		return view('boards/board_form', $data);
	}

	public function getEdit($id)
	{
		$model = new BoardsModel();
		$board = $model->getBoard($id);

		if (empty($board)) {
			return redirect()->to(base_url() . '/boards');
		}
		$data['title'] = 'Board bearbeiten';
		$data['board'] = $board;
		return view('boards/board_form', $data);
	}

	public function postSave($id = null)
	{
		$validation = \Config\Services::validation();

		if ($validation->run($_POST, 'boardsbearbeiten')) {
			$model = new BoardsModel();
			$saveData = [
				'board' => $this->request->getPost('board'),
			];

			if (empty($id)) {
				$model->insert($saveData);
			} else {
				$model->update($id, $saveData);
			}

			return redirect()->to(base_url('boards'));
		}

		$data['origin'] = base_url('boards');
		$data['title'] = empty($id) ? 'Neues Board erstellen' : 'Board bearbeiten';
		$data['board'] = $_POST;
		$data['error'] = $validation->getErrors();

		return view('boards/board_form', $data);
	}

	public function postDelete($id)
	{
		$model = new BoardsModel();

		if (!empty($id)) {
			if ($model->delete($id)) {
				return redirect()->to(base_url('boards'))
					->with('success', 'Board wurde erfolgreich gelöscht!');
			} else {
				return redirect()->to(base_url('boards'))
					->with('error', 'Fehler beim Löschen des Boards!');
			}
		}

		return redirect()->to(base_url('boards'))
			->with('error', 'Keine Board-ID angegeben!');
	}
}
