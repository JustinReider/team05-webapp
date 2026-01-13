<?php

namespace App\Models;

use CodeIgniter\Model;

class TasksModel extends Model
{
	protected $table = 'tasks';
	protected $primaryKey = 'id';
	protected $returnType = 'array';
	protected $allowedFields = [];

	public function queryBuilder($sql, $binds = [])
	{
		$query = $this->db->query($sql, $binds);
		return $query->getResultArray();
	}

	public function getTasks($board = ""): array
	{
		if (!empty($board)) {
			$sql = "SELECT * FROM tasks WHERE boardid = ? ORDER BY tasks ASC";
			return $this->queryBuilder($sql, [$board]);
		} else {
			$sql = "SELECT * FROM tasks ORDER BY tasks ASC";
			return $this->queryBuilder($sql);
		}
	}
}
