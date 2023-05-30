<?php

use Inteve\SimpleComponents;
use Inteve\SimpleComponents\DirectoryFactory;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


test('non exists component', function () {
	$componentFactory = new DirectoryFactory(__DIR__ . '/templates');

	Assert::null($componentFactory->create('nonExists'));
});


test('create', function () {
	$componentFactory = new DirectoryFactory(__DIR__ . '/templates');

	$component = $componentFactory->create('MyComponent', [
		'name' => 'John',
	]);
	Assert::type(SimpleComponents\Component::class, $component);
	Assert::same(__DIR__ . '/templates/MyComponent.latte', $component->getFile());
	Assert::same([
		'name' => 'John',
	], $component->getParameters());
});
