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
			$sql = "
				SELECT
				    t.*,
				    ta.taskartenicon,
				    COALESCE(
				        JSON_ARRAYAGG(
				            CASE
				                WHEN p.id IS NOT NULL THEN JSON_OBJECT(
				                    'id', p.id,
				                    'vorname', p.vorname,
				                    'name', p.name,
				                    'email', p.email
				                )
				            END
				        ),
				        JSON_ARRAY()
				    ) AS personen
				FROM tasks t
				JOIN taskarten ta ON ta.id = t.taskartenid
				LEFT JOIN personen_tasks pt ON pt.tasksid = t.id
				LEFT JOIN personen p ON p.id = pt.personenid
				WHERE t.spaltenid = ?
				GROUP BY t.id
				ORDER BY t.sortid ASC;
			";
			$tasks = $this->queryBuilder($sql, [$spalte['id']]);
			foreach ($tasks as &$task) {
				$task['personen'] = json_decode($task['personen'], true) ?? [];
			}
			unset($task);

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

	public function getBoardByTask($id)
	{
		return $this->select('s.boardsid')
			->join('spalten s', 'tasks.spaltenid = s.id')
			->where('tasks.id', $id)
			->first();
	}
}
