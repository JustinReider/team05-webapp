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

	public function getSpaltenWithBoards(): array
	{
		return $this->select("CONCAT(spalten.spalte, ' (', boards.board, ')') AS spalte, spalten.id, spalten.boardsid, spalten.spaltenbeschreibung, spalten.sortid", false)
			->join('boards', 'boards.id = spalten.boardsid')
			->orderBy('spalten.boardsid', 'ASC')
			->orderBy('spalten.sortid', 'ASC')
			->findAll();
	}

	public function getSpaltenListeMitTasks(): array
	{
		return $this->db->table('spalten')
			->select(
				'spalten.id,
                 boards.board AS board_name,
             spalten.sortid,
             spalten.spalte,
             spalten.spaltenbeschreibung,
             group_concat(CONCAT("<li>", tasks.tasks, "</li>") separator "") AS task_liste',
				false
			)
			->join('boards', 'boards.id = spalten.boardsid', 'left')
			->join('tasks', 'tasks.spaltenid = spalten.id', 'left')
			->groupBy('spalten.id, boards.board, spalten.sortid, spalten.spalte, spalten.spaltenbeschreibung')
			->orderBy('boards.board', 'ASC')
			->orderBy('spalten.sortid', 'ASC')
			->orderBy('spalten.id', 'ASC')
			->get()
			->getResultArray();
	}

	public function getSpaltenListe(): array
	{
		return $this->db->table('spalten')
			->select(
				'spalten.id,
                 boards.board AS board_name,
             spalten.sortid,
             spalten.spalte,
             spalten.spaltenbeschreibung',
				false
			)
			->join('boards', 'boards.id = spalten.boardsid', 'left')
			->groupBy('spalten.id, boards.board, spalten.sortid, spalten.spalte, spalten.spaltenbeschreibung')
			->orderBy('boards.board', 'ASC')
			->orderBy('spalten.sortid', 'ASC')
			->orderBy('spalten.id', 'ASC')
			->get()
			->getResultArray();
	}

	public function getSpalte($id)
	{
		return  $this->find($id);
	}

	public function getSpaltenByBoard($boardid)
	{
		return $this->where('boardsid', $boardid)
			->orderBy('sortid', 'ASC')
			->findAll();
	}
}
