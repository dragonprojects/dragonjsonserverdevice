<?php
/**
 * @link http://dragonjsonserver.de/
 * @copyright Copyright (c) 2012-2014 DragonProjects (http://dragonprojects.de/)
 * @license http://license.dragonprojects.de/dragonjsonserver.txt New BSD License
 * @author Christoph Herrmann <developer@dragonprojects.de>
 * @package DragonJsonServerDevice
 */

/**
 * @return array
 */
return [
	'dragonjsonserverdevice' => [
		'deviceplatforms' => [
			'browser' => ['browser_id'],
		],
	],
	'dragonjsonserver' => [
	    'apiclasses' => [
	        '\DragonJsonServerDevice\Api\Device' => 'Device',
	    ],
	],
	'service_manager' => [
		'invokables' => [
            '\DragonJsonServerDevice\Service\Device' => '\DragonJsonServerDevice\Service\Device',
		],
	],
	'doctrine' => [
		'driver' => [
			'DragonJsonServerDevice_driver' => [
				'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
				'cache' => 'array',
				'paths' => [
					__DIR__ . '/../src/DragonJsonServerDevice/Entity'
				],
			],
			'orm_default' => [
				'drivers' => [
					'DragonJsonServerDevice\Entity' => 'DragonJsonServerDevice_driver'
				],
			],
		],
	],
];
