<?php /** @noinspection UsingInclusionReturnValueInspection */
declare(strict_types = 1);

use yii\log\FileTarget;
use yii\web\AssetManager;
use yii\web\ErrorHandler;


$config = [
	'id' => 'basic',
	'basePath' => dirname(__DIR__),
	'bootstrap' => ['log'],
	'aliases' => [
		'@vendor' => './vendor',
		'@bower' => '@vendor/bower-asset',
		'@npm' => '@vendor/npm-asset',
	],
	'components' => [
		'request' => [
			'cookieValidationKey' => 'sosijopu',
		],
		'log' => [
			'traceLevel' => YII_DEBUG?3:0,
			'targets' => [
				[
					'class' => FileTarget::class,
					'levels' => ['error', 'warning'],
				],
			],
		],
	]
];

return $config;