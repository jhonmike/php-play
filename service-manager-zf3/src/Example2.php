<?php
namespace Play;

class Example2
{
	private $example;

	public function __construct(Example $example)
	{
		$this->example = $example;
	}

	public function sayHello()
	{
		$this->example->hello();
	}
}