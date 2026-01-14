<?php

namespace App\Models;

use CodeIgniter\Model;

class SpaltenModel extends Model
{
	protected $table = 'spalten';
	protected $primaryKey = 'id';
	protected $returnType = 'array';
	protected $allowedFields = [
		'id',
		'boardsid',
		'sortid',
		'spalte',
		'spaltenbeschreibung',
	];

	public function getSpalten(): array
	{
		return $this->findAll();
	}
}
