<?php

use Inteve\SimpleComponents;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


class MyComponents implements SimpleComponents\IComponents
{
	public function createTemplate($componentName, array $args = [])
	{
		if ($componentName === 'my-component') {
			return new SimpleComponents\Template(__DIR__ . '/templates/MyComponent.latte', $args);
		}

		return NULL;
	}
}


test('{component}', function () {
	$components = new MyComponents;
	$latte = new Latte\Engine;
	\Inteve\SimpleComponents\LatteMacros::installToLatte($latte, $components);

	Assert::same("Hello, John!\nHello, Wick!\n", $latte->renderToString(__DIR__ . '/templates/page-Homepage.latte'));
});


test('Missing component', function () {
	$components = new MyComponents;
	$latte = new Latte\Engine;
	\Inteve\SimpleComponents\LatteMacros::installToLatte($latte, $components);

	Assert::exception(function () use ($latte) {
		$latte->renderToString(__DIR__ . '/templates/page-MissingComponent.latte');
	}, SimpleComponents\InvalidStateException::class, "Component 'my-missing' not found.");
});


test('With modifiers', function () {
	$components = new MyComponents;
	$latte = new Latte\Engine;
	\Inteve\SimpleComponents\LatteMacros::installToLatte($latte, $components);

	Assert::exception(function () use ($latte) {
		$latte->renderToString(__DIR__ . '/templates/page-WithModifiers.latte');
	}, Latte\CompileException::class, 'Filters are not allowed in {component} in %a%');
});


test('No arguments', function () {
	$components = new MyComponents;
	$latte = new Latte\Engine;
	\Inteve\SimpleComponents\LatteMacros::installToLatte($latte, $components);

	Assert::exception(function () use ($latte) {
		$latte->renderToString(__DIR__ . '/templates/page-NoArguments.latte');
	}, Latte\CompileException::class, 'Missing arguments in {component} in %a%');
});


test('Runtime Renderer', function () {
	Assert::exception(function () {
		new \Inteve\SimpleComponents\Runtime\Renderer;
	}, \Inteve\SimpleComponents\StaticClassException::class, 'This is static class.');
});
