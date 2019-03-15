<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "armfemanager".
 *
 * Auto generated 08-03-2018 22:30
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array(
	'title' => 'ARM Femanager',
	'description' => 'Extends femanager with custom fields and country ordering',
	'category' => 'plugin',
	'author' => 'Anisur R. Mullick',
	'author_email' => 'anisur@armtechnologies.com',
	'author_company' => 'ARM Technologies',
	'shy' => '',
	'priority' => '',
	'module' => '',
	'state' => 'stable',
	'internal' => '',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => '',
	'clearCacheOnLoad' => 0,
	'lockType' => '',
	'version' => '3.0.0',
	'constraints' => array(
		'depends' => array(
			'cms' => '8.7',
                        'femanager' => '3.3',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
);
