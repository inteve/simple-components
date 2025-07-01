<?php

declare(strict_types=1);

use Inteve\SimpleComponents;
use Inteve\SimpleComponents\DirectoryFactory;
use Inteve\SimpleComponents\MultiFactory;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


class MyComponents implements SimpleComponents\ComponentFactory
{
	public function create($componentName, array $args = [])
	{
		if ($componentName === 'cool-component') {
			return new SimpleComponents\GenericComponent(__DIR__ . '/templates/CoolComponent.latte', $args);
		}

		return NULL;
	}
}


test('empty', function () {
	$componentFactory = new MultiFactory([]);
	Assert::null($componentFactory->create('any'));
});


test('non exists component', function () {
	$componentFactory = new MultiFactory([
		new DirectoryFactory(__DIR__ . '/templates'),
		new MyComponents
	]);

	Assert::null($componentFactory->create('nonExists'));
});


test('create', function () {
	$componentFactory = new MultiFactory([
		new DirectoryFactory(__DIR__ . '/templates'),
		new MyComponents
	]);

	$component = $componentFactory->create('cool-component', [
		'name' => 'John',
	]);
	Assert::type(SimpleComponents\Component::class, $component);
	Assert::same(__DIR__ . '/templates/CoolComponent.latte', $component->getFile());
	Assert::same([
		'name' => 'John',
	], $component->getParameters());
});
