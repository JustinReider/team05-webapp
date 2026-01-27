<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\StrictRules\CreditCardRules;
use CodeIgniter\Validation\StrictRules\FileRules;
use CodeIgniter\Validation\StrictRules\FormatRules;
use CodeIgniter\Validation\StrictRules\Rules;

class Validation extends BaseConfig
{
    // --------------------------------------------------------------------
    // Setup
    // --------------------------------------------------------------------

	/**
	 * Stores the classes that contain the
	 * rules that are available.
	 *
	 * @var list<string>
	 */
	public array $ruleSets = [
		Rules::class,
		FormatRules::class,
		FileRules::class,
		CreditCardRules::class,
	];

	/**
	 * Specifies the views that are used to display the
	 * errors.
	 *
	 * @var array<string, string>
	 */
	public array $templates = [
		'list'   => 'CodeIgniter\Validation\Views\list',
		'single' => 'CodeIgniter\Validation\Views\single',
	];

	// --------------------------------------------------------------------
	// Rules
	// --------------------------------------------------------------------

	public array $spaltenbearbeiten = [
		'spalte' => [
			'rules'  => 'required',
			'errors' => [
				'required' => 'Bitte eine Spalten-Bezeichnung eingeben.',
			],
		],
		'spaltenbeschreibung' => [
			'rules'  => 'required',
			'errors' => [
				'required' => 'Bitte eine Spaltenbeschreibung eingeben.',
			],
		],
		'sortid' => [
			'rules'  => 'required|integer',
			'errors' => [
				'required' => 'Bitte eine Sortid eingeben.',
				'integer'  => 'Die Sortid muss eine ganze Zahl sein.',
			],
		],
		'boardsid' => [
			'rules' => 'required|integer',
			'errors' => [
				'required' => 'Bitte ein Board auswählen.',
				'integer'  => 'Die Boardid muss eine ganze Zahl sein.',
			],
		],
	];

	public array $tasksbearbeiten = [
		'tasks' => [
			'label' => 'Task',
			'rules' => 'required',
			'errors' => [
				'required' => 'Bitte das Feld "Task" ausfüllen.'
			]
		],
		'notizen' => [
			'label' => 'Notizen',
			'rules' => 'required',
			'errors' => [
				'required' => 'Bitte das Feld "Notizen" ausfüllen.'
			]
		],
		'spaltenid' => [
			'label' => 'Spalten-ID',
			'rules' => 'required|integer',
			'errors' => [
				'required' => 'Bitte eine Spalte auswählen.',
				'integer' => 'Die Spalten-ID muss eine Zahl sein.'
			]
		],
		'taskartenid' => [
			'label' => 'Taskarten-ID',
			'rules' => 'required|integer',
			'errors' => [
				'required' => 'Bitte eine Taskart auswählen.',
				'integer' => 'Die Taskarten-ID muss eine Zahl sein.'
			]
		],
		'sortid' => [
			'label' => 'Sortier-ID',
			'rules' => 'required|integer',
			'errors' => [
				'required' => 'Bitte eine Sortier-ID angeben.',
				'integer' => 'Die Sortier-ID muss eine Zahl sein.'
			]
		],
		'erinnerungsdatum' => [
			'label' => 'Erinnerungsdatum',
			'rules' => 'permit_empty|valid_date[Y-m-d]',
			'errors' => [
				'valid_date' => 'Bitte ein gültiges Datum angeben.'
			]
		],
	];
}
