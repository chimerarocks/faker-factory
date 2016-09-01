<?php

namespace ChimeraRocks\OptFaker;

use ChimeraRocks\DinamycClass\ClassBuilder;
use ChimeraRocks\DinamycClass\ClassMaker;

class Factory 
{
	private $classBuilder;
	private $classMaker;

	public function __construct()
	{
		$this->classBuilder = new ClassBuilder;
	}

	public function build($class, $configurations)
	{
		$this->classBuilder->build($class, $configurations);
		return $this;
	}

	public function make($class, $count = null)
	{
		$this->classMaker = new ClassMaker($this->classBuilder);
		$this->classMaker->make($class, $count);
		return $this;
	}

	public function each($callback)
	{
		$this->classMaker->each($callback);
		return $this;
	}

	public function create()
	{
		return $this->classMaker->create();
	}
}