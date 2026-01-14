<?php

namespace App\Models;

use CodeIgniter\Model;

class TasksModel extends Model
{
	protected $table = 'tasks';
	protected $primaryKey = 'id';
	protected $returnType = 'array';
	protected $allowedFields = [
		'tasks',
		'taskartenid',
		'personenid',
		'spaltenid',
		'erinnerungsdatum',
		'erinnerung',
		'notiz',
		'erledigt',
		'geloescht'
		'boardid'
	];

	public function queryBuilder($sql, $binds = [])
	{
		$query = $this->db->query($sql, $binds);
		return $query->getResultArray();
	}

public function getTasks($board = "", $id = null): array
	{
		if ($id == null) {
			if (!empty($board)) {
				$sql = "SELECT * FROM tasks WHERE boardid = ? ORDER BY tasks ASC";
				return $this->queryBuilder($sql, [$board]);
			} else {
				$sql = "SELECT * FROM tasks ORDER BY tasks ASC";
				return $this->queryBuilder($sql);
			}
		} else return $this->find($id);
	}
}
