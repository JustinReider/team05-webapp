<?php

namespace App\Models;

use CodeIgniter\Model;

class PersonenTasksModel extends Model
{
    protected $table = 'personen_tasks';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['taskid', 'personenid'];
}