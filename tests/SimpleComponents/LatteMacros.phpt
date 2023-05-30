<?php

use Inteve\SimpleComponents;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


class MyComponents implements SimpleComponents\ComponentFactory
{
	public function create($componentName, array $args = [])
	{
		if ($componentName === 'my-component') {
			return new SimpleComponents\GenericComponent(__DIR__ . '/templates/MyComponent.latte', $args);
		}

		return NULL;
	}
}


test('{component}', function () {
	$componentFactory = new MyComponents;
	$latte = new Latte\Engine;
	\Inteve\SimpleComponents\LatteMacros::installToLatte($latte, $componentFactory);

	Assert::same("Hello, John!\nHello, Wick!\n", $latte->renderToString(__DIR__ . '/templates/page-Homepage.latte'));
});


test('Missing component', function () {
	$componentFactory = new MyComponents;
	$latte = new Latte\Engine;
	\Inteve\SimpleComponents\LatteMacros::installToLatte($latte, $componentFactory);

	Assert::exception(function () use ($latte) {
		$latte->renderToString(__DIR__ . '/templates/page-MissingComponent.latte');
	}, SimpleComponents\InvalidStateException::class, "Component 'my-missing' not found.");
});


test('With modifiers', function () {
	$componentFactory = new MyComponents;
	$latte = new Latte\Engine;
	\Inteve\SimpleComponents\LatteMacros::installToLatte($latte, $componentFactory);

	Assert::exception(function () use ($latte) {
		$latte->renderToString(__DIR__ . '/templates/page-WithModifiers.latte');
	}, Latte\CompileException::class, 'Thrown exception \'Filters are not allowed in {component} macro.\' in %a%');
});


test('No arguments', function () {
	$componentFactory = new MyComponents;
	$latte = new Latte\Engine;
	\Inteve\SimpleComponents\LatteMacros::installToLatte($latte, $componentFactory);

	Assert::exception(function () use ($latte) {
		$latte->renderToString(__DIR__ . '/templates/page-NoArguments.latte');
	}, Latte\CompileException::class, 'Thrown exception \'Missing arguments in {component} macro.\' in %a%');
});


test('Runtime Renderer', function () {
	Assert::exception(function () {
		new \Inteve\SimpleComponents\Runtime\Renderer;
	}, \Inteve\SimpleComponents\StaticClassException::class, 'This is static class.');
});
