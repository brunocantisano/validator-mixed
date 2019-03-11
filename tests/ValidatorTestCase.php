<?php

abstract class ValidatorTestCase extends Orchestra\Testbench\TestCase
{
	public function setUp()
	{
		parent::setUp();

		$this->app->register(\ValidatorMixed\BccDevelValidator\ValidatorProvider::class);
	}
}