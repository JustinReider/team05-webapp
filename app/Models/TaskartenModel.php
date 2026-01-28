<?php

namespace App\Models;

use CodeIgniter\Model;

class TaskartenModel extends Model
{
	protected $table = 'taskarten';
	protected $primaryKey = 'id';
	protected $returnType = 'array';
	protected $allowedFields = [
		'id',
		'taskart',
		'taskartenicon',
	];

	public function getTaskarten(): array
	{
		return $this->findAll();
	}
}
