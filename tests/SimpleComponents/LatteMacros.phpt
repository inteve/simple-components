<?php

use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


class MyComponent implements \Inteve\SimpleComponents\IComponentFactory
{
	public function getName()
	{
		return 'my-component';
	}


	public function createTemplate(array $args)
	{
		return new \Inteve\SimpleComponents\Template(__DIR__ . '/templates/MyComponent.latte', $args);
	}
}


class LatteFactory implements \Nette\Bridges\ApplicationLatte\ILatteFactory
{
	function create()
	{
		return new \Latte\Engine;
	}
}


test('{component} macro', function () {
	$latteFactory = new LatteFactory;
	$templateFactory = new \Nette\Bridges\ApplicationLatte\TemplateFactory($latteFactory);
	$components = new \Inteve\SimpleComponents\Components([
		new MyComponent,
	], $templateFactory);

	$latte = new Latte\Engine;
	\Inteve\SimpleComponents\LatteMacros::installToLatte($latte, $components);
	Assert::same("Hello, John!\nHello, Wick!\n", $latte->renderToString(__DIR__ . '/templates/page-Homepage.latte'));
});
