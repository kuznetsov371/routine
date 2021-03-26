<?php
$methods = [
	'submitAmbassador' => [
		'params' => [
			[
				'name' => 'firstname',
				'source' => 'p',
				'pattern' => 'names',
				'required' => true
			],
			[
				'name' => 'secondname',
				'source' => 'p',
				'pattern' => 'names',
				'required' => true
			],
			[
				'name' => 'position',
				'source' => 'p',
				'pattern' => 'names',
				'required' => false,
				'default' => 'Не вказано'
			],
			[
				'name' => 'phone',
				'source' => 'p',
				'pattern' => 'phone',
				'required' => true
			],
			[
				'name' => 'email',
				'source' => 'p',
				'pattern' => 'email',
				'required' => false,
				'default' => 'Не вказано'
			],
			[
				'name' => 'IBAN',
				'source' => 'p',
				'pattern' => 'IBAN',
				'required' => false,
				'default' => 'Не вказано'
			],
		]
	]
];