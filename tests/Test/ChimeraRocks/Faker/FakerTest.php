<?php

namespace Test\ChimeraRocks\Faker;

use ChimeraRocks\OptFaker\Factory;
use ChimeraRocks\OptFaker\Faker;
use Mockery;
use PHPUnit\Framework\TestCase;
use Test\Stubs\Model;

class FakerTest extends TestCase
{

	public function test_can_make_a_object_relative_to_a_class_and_should_returns_a_object_when_creating_one()
	{
		$faker = Faker::create();
		$factory = new Factory;

		$configuration = [
			'name' => $faker->name,
			'description' => $faker->sentence
		];

		$factory->build(Model::class, $configuration);

		$result = $factory->make(Model::class);

		//should not return the objects, that will be returned with create()
		$this->assertInstanceOf(Factory::class, $result);

		$model = $factory->create();
		
		$this->assertInstanceOf(Model::class, $model);
		$this->assertEquals($configuration['name'], $model->getName());
		$this->assertEquals($configuration['description'], $model->getDescription());
	}

	public function test_can_make_many_objects_relative_to_a_class_and_should_returns_a_array_when_creating_many()
	{
		$faker = Faker::create();
		$factory = new Factory;

		$configuration = [
			'name' => $faker->name,
			'description' => $faker->sentence
		];

		$factory->build(Model::class, $configuration);
		$result = $factory->make(Model::class,5);

		//should not return the objects, that will be returned with create()
		$this->assertInstanceOf(Factory::class, $result);

		$objects = $result->create();
		
		$this->assertCount(5, $objects);

		$model = $objects[4];
		$this->assertInstanceOf(Model::class, $model);
		$this->assertEquals($configuration['name'], $model->getName());
		$this->assertEquals($configuration['description'], $model->getDescription());
	}

	public function test_can_change_attributes_of_elements_dinamically_after_creation()
	{
		$faker = Faker::create();
		$factory = new Factory;

		$configuration = [
			'name' => $faker->name,
			'description' => $faker->sentence
		];

		$factory->build(Model::class, $configuration);

		$i = 1;

		$result = $factory->make(Model::class,5)->each(function($object) use (&$i, $configuration) {
			$object->setDescription($configuration['description'] . $i++);
		});

		//should not return the objects, that will be returned with create()
		$this->assertInstanceOf(Factory::class, $result);

		$objects = $result->create();
		
		$this->assertCount(5, $objects);

		$model = $objects[0];
		$this->assertInstanceOf(Model::class, $model);
		$this->assertEquals($configuration['name'], $model->getName());
		$this->assertEquals($configuration['description'] . '1', $model->getDescription());
		$model = $objects[1];
		$this->assertEquals($configuration['description'] . '2', $model->getDescription());
		$model = $objects[2];
		$this->assertEquals($configuration['description'] . '3', $model->getDescription());
		$model = $objects[3];
		$this->assertEquals($configuration['description'] . '4', $model->getDescription());
		$model = $objects[4];
		$this->assertEquals($configuration['description'] . '5', $model->getDescription());
	}

	public function test_can_change_attributes_of_elements_dinamically_after_creation_of_one_object()
	{
		$faker = Faker::create();
		$factory = new Factory;

		$configuration = [
			'name' => $faker->name,
			'description' => $faker->sentence
		];

		$factory->build(Model::class, $configuration);

		$i = 1;

		$result = $factory->make(Model::class)->each(function($object) use (&$i, $configuration) {
			$object->setDescription($configuration['description'] . $i++);
		});

		//should not return the objects, that will be returned with create()
		$this->assertInstanceOf(Factory::class, $result);

		$model = $result->create();
		
		$this->assertInstanceOf(Model::class, $model);
		$this->assertEquals($configuration['name'], $model->getName());
		$this->assertEquals($configuration['description'] . 1, $model->getDescription());
	}
}