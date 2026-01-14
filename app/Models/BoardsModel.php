<?php

namespace App\Models;

use CodeIgniter\Model;

class BoardsModel extends Model
{
	protected $table = 'boards';
	protected $primaryKey = 'id';
	protected $returnType = 'array';
	protected $allowedFields = [
		'id',
		'board'
	];

	public function getBoards(): array
	{
		return $this->findAll();
	}
	public function getBoardName($board): array
	{
		return $this->where('id', $board)->select('board')->first();
	}
}
