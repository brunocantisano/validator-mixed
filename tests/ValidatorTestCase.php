<?php

abstract class ValidatorTestCase extends Orchestra\Testbench\TestCase
{
	public function setUp()
	{
		parent::setUp();

		$this->app->register(\BrunoCantisano\ValidatorMixed\ValidatorProvider::class);
	}
}