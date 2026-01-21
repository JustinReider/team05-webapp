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
            ->orderBy('spalten.sortid', 'ASC')
            ->get()
            ->getResultArray();
    }

}
