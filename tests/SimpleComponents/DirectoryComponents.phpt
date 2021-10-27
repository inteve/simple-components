<?php

use Inteve\SimpleComponents;
use Inteve\SimpleComponents\DirectoryComponents;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


test('non exists component', function () {
	$components = new DirectoryComponents(__DIR__ . '/templates');

	Assert::null($components->createTemplate('nonExists'));
});


test('create', function () {
	$components = new DirectoryComponents(__DIR__ . '/templates');

	$template = $components->createTemplate('MyComponent', [
		'name' => 'John',
	]);
	Assert::type(SimpleComponents\Template::class, $template);
	Assert::same(__DIR__ . '/templates/MyComponent.latte', $template->getFile());
	Assert::same([
		'name' => 'John',
	], $template->getParameters());
});
