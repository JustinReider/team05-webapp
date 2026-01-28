<?php

namespace App\Controllers;

use App\Models\BoardsModel;
use App\Models\SpaltenModel;

class Spalten extends BaseController
{
	public function index(): string
	{
		$model = new SpaltenModel();

		$data = [
			'spalten' => $model->getSpaltenListe(),
		];

		return view('spalten/spalten', $data);
	}

	public function getNew(): string
	{
		$data['title'] = 'Neue Spalte erstellen';
		$data['spalte'] = null;
		$data['boards'] = new BoardsModel()->getBoards();
		return view('spalten/spalte_form', $data);
	}

	public function getEdit($id)
	{
		$model = new SpaltenModel();
		$spalte = $model->getSpalte($id);

		if (empty($spalte)) {
			return redirect()->to(base_url() . '/spalten');
		}
		$data['title'] = 'Spalte bearbeiten';
		$data['spalte'] = $spalte;
		$data['boards'] = new BoardsModel()->getBoards();
		return view('spalten/spalte_form', $data);
	}

	public function postSave($id = null)
	{
		$validation = \Config\Services::validation();

		if ($validation->run($_POST, 'spaltenbearbeiten')) {
			$model = new SpaltenModel();
			$saveData = [
				'boardsid' => $this->request->getPost('boardsid'),
				'spalte' => $this->request->getPost('spalte'),
				'spaltenbeschreibung' => $this->request->getPost('spaltenbeschreibung'),
				'sortid' => $this->request->getPost('sortid'),
			];

			if (empty($id)) {
				$model->insert($saveData);
			} else {
				$model->update($id, $saveData);
			}

			return redirect()->to(base_url('spalten'));
		}

		$data['origin'] = base_url('spalten');
		$data['title'] = empty($id) ? 'Neue Spalte erstellen' : 'Spalte bearbeiten';
		$data['spalte'] = $_POST;
		$data['error'] = $validation->getErrors();

		return view('spalten/spalte_form', $data);
	}

	public function postDelete($id)
	{
		$model = new SpaltenModel();

		if (!empty($id)) {
			if ($model->delete($id)) {
				return redirect()->to(base_url('spalten'))
					->with('success', 'Spalte wurde erfolgreich gelöscht!');
			} else {
				return redirect()->to(base_url('spalten'))
					->with('error', 'Fehler beim Löschen der Spalte!');
			}
		}

		return redirect()->to(base_url('spalten'))
			->with('error', 'Keine Spalten-ID angegeben!');
	}
}
