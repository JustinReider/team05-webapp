<?php

namespace App\Controllers;

use App\Models\PersonenModel;

class Personen extends BaseController
{
	public function getIndex()
	{
		$model = new PersonenModel();
		$data['personen'] = $model->getData();
		return view('personen/personen', $data);
	}
}
