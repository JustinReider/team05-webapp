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
