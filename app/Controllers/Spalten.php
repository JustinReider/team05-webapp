<?php

namespace App\Controllers;

use App\Models\SpaltenModel;

class Spalten extends BaseController
{
    public function index() : string
    {
        $model = new SpaltenModel();

        $data = [
            'spalten' => $model->getSpaltenListeMitTasks(),
        ];

        return view('spalten/spalten', $data);
    }

    public function new() : string {
        return view('spalten/new');
    }

    public function postSave($id = null)
    {
        $model = new SpaltenModel();
        $validation = \Config\Services::validation();

        if ($validation->run($_POST, 'spaltenbearbeiten')) {
            $id = $this->request->getPost('id');

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

        $data['spalte'] = $_POST;
        $data['error'] = $validation->getErrors();

        return view('spalten/new', $data);
    }
}
