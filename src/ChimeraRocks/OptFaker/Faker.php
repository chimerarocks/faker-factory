<?php

namespace ChimeraRocks\OptFaker;

require_once __DIR__ . '/../../../vendor/fzaninotto/faker/src/autoload.php';

use Faker\Factory as Factory;

class Faker
{
	public static function create()
	{
		return Factory::create();
	}
}
