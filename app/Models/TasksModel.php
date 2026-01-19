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
		'sortid',
		'erinnerungsdatum',
		'erinnerung',
		'notizen',
		'erledigt',
		'geloescht',
	];

	public function queryBuilder($sql, $binds = [])
	{
		$query = $this->db->query($sql, $binds);
		return $query->getResultArray();
	}

	public function getColumnsTasks($board = 1): array
	{
		$sql = "SELECT id, spalte, spaltenbeschreibung FROM spalten WHERE boardsid = ? ORDER BY sortid ASC";
		$spalten = $this->queryBuilder($sql, [$board]);
		$result = [];
		foreach ($spalten as $spalte) {
			$sql = "SELECT * FROM tasks WHERE spaltenid = ? ORDER BY sortid ASC";
			$tasks = $this->queryBuilder($sql, [$spalte['id']]);
			$result[$spalte['id']] = [
				'spalte' => $spalte['spalte'],
				'spaltenbeschreibung' => $spalte['spaltenbeschreibung'],
				'tasks' => $tasks,
			];
		}
		return $result;
	}

	public function getTask($id): array
	{
		return $this->find($id);
	}
}
