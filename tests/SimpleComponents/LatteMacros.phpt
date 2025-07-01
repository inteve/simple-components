<?php

declare(strict_types=1);

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

		if ($componentName === 'my-html-component') {
			return new SimpleComponents\GenericComponent(__DIR__ . '/templates/MyHtmlComponent.latte', $args);
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


test('component() function', function () {
	$componentFactory = new MyComponents;
	$latte = new Latte\Engine;

	if (method_exists($latte, 'addFunction')) {
		\Inteve\SimpleComponents\LatteMacros::installToLatte($latte, $componentFactory);
		Assert::same("Hello, Hello, John Wick &lt;3!\n!\nHello, Hello, <b>John Wick</b>!\n!\n<a title=\"&lt;b&gt;Hello&lt;/b&gt;, &#123;John&lt;3!\n\">test</a>\n", $latte->renderToString(__DIR__ . '/templates/page-ComponentFunction.latte'));
	}
});


test('component() function named arguments', function () {
	$componentFactory = new MyComponents;
	$latte = new Latte\Engine;

	if (method_exists($latte, 'addFunction') && PHP_VERSION_ID >= 81000) {
		\Inteve\SimpleComponents\LatteMacros::installToLatte($latte, $componentFactory);
		Assert::same("Hello, Hello, John Wick &lt;3!\n!\nHello, Hello, <b>John Wick</b>!\n!\n<a title=\"&lt;b&gt;Hello&lt;/b&gt;, &#123;John&lt;3!\n\">test</a>\n", $latte->renderToString(__DIR__ . '/templates/page-ComponentFunction.named.latte'));
	}
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
