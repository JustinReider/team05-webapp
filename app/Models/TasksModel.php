<?php namespace App\Models;

use CodeIgniter\Model;

class TasksModel extends Model {
	protected $table = 'personen';
	protected $primaryKey = 'id';
	protected $returnType = 'array';
	protected $allowedFields = [];
	
	/**
	 * Get all persons from the database
	 *
	 * @return array Array of person records or empty array if none found
	 */
	public function getData(): array
	{
		try {
			return $this->findAll() ?? [];
		} catch (\Exception $e) {
			log_message('error', 'Error fetching persons: ' . $e->getMessage());
			return [];
		}
	}
}

