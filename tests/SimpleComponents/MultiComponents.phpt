<?php

use Inteve\SimpleComponents;
use Inteve\SimpleComponents\DirectoryComponents;
use Inteve\SimpleComponents\MultiComponents;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


class MyComponents implements SimpleComponents\IComponents
{
	public function createTemplate($componentName, array $args = [])
	{
		if ($componentName === 'cool-component') {
			return new SimpleComponents\Template(__DIR__ . '/templates/CoolComponent.latte', $args);
		}

		return NULL;
	}
}


test('empty', function () {
	$components = new MultiComponents([]);
	Assert::null($components->createTemplate('any'));
});


test('non exists component', function () {
	$components = new MultiComponents([
		new DirectoryComponents(__DIR__ . '/templates'),
		new MyComponents
	]);

	Assert::null($components->createTemplate('nonExists'));
});


test('create', function () {
	$components = new MultiComponents([
		new DirectoryComponents(__DIR__ . '/templates'),
		new MyComponents
	]);

	$template = $components->createTemplate('cool-component', [
		'name' => 'John',
	]);
	Assert::type(SimpleComponents\Template::class, $template);
	Assert::same(__DIR__ . '/templates/CoolComponent.latte', $template->getFile());
	Assert::same([
		'name' => 'John',
	], $template->getParameters());
});
