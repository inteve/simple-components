# Inteve\SimpleComponents

[![Build Status](https://github.com/inteve/simple-components/workflows/Build/badge.svg)](https://github.com/inteve/simple-components/actions)
[![Downloads this Month](https://img.shields.io/packagist/dm/inteve/simple-components.svg)](https://packagist.org/packages/inteve/simple-components)
[![Latest Stable Version](https://poser.pugx.org/inteve/simple-components/v/stable)](https://github.com/inteve/simple-components/releases)
[![License](https://img.shields.io/badge/license-New%20BSD-blue.svg)](https://github.com/inteve/simple-components/blob/master/license.md)

Simple independent components for Latte templates.

<a href="https://www.janpecha.cz/donate/"><img src="https://buymecoffee.intm.org/img/donate-banner.v1.svg" alt="Donate" height="100"></a>


## Installation

[Download a latest package](https://github.com/inteve/simple-components/releases) or use [Composer](http://getcomposer.org/):

```
composer require inteve/simple-components
```

Inteve\SimpleComponents requires PHP 5.6.0 or later.


## Usage

### 1. create components factory

```php
use Inteve\SimpleComponents;


class MyComponentFactory implements SimpleComponents\ComponentFactory
{
	public function create($componentName, array $args = [])
	{
		if ($componentName === 'menu') {
			return new SimpleComponents\GenericComponent(__DIR__ . '/components/Menu.latte');

		} elseif ($componentName === 'breadcrumbs') {
			return new SimpleComponents\GenericComponent(__DIR__ . '/components/Breadcrumbs.latte', $args);
		}

		return NULL;
	}
}
```


### 2. register `{component}` macro

**In plain PHP:**

```php
$latte = new Latte\Engine;
$componentFactory = new MyComponentFactory;
\Inteve\SimpleComponents\LatteMacros::installToLatte($latte, $componentFactory);
```


**In Nette presenter:**

```php
abstract class BasePresenter extends \Nette\Application\UI\Presenter
{
	/** @var \Inteve\SimpleComponents\ComponentFactory @inject */
	public $componentFactory;


	protected function createTemplate()
	{
		$template = parent::createTemplate();
		assert($template instanceof \Nette\Bridges\ApplicationLatte\Template);
		\Inteve\SimpleComponents\LatteMacros::installToLatte($template->getLatte(), $this->componentFactory);
		return $template;
	}
}
```


### 3. use it in your app template

```latte
{block content}
	<h1>My Page</h1>

	{component menu}
	{component breadcrumbs, items => $breadcrumbItems}

	<p>Lorem ipsum dolor sit amet.</p>
{/block}
```


## Prepared implementations

### `DirectoryFactory`

Loads template files from specified directory.

```
/app
	/components
		breadcrumbs.latte
		menu.latte
```

```php
$componentFactory = new SimpleComponents\DirectoryFactory('/path/to/app/components');
```

```latte
{component menu}
{component breadcrumbs}
```


### `MultiFactory`

Packs multiple `ComponentFactory` implementations to one class.

```php
$componentFactory = new SimpleComponents\MultiFactory([
	new MyComponentFactory,
	new SimpleComponents\DirectoryFactory('/path/to/app/components')
]);
```

```latte
{component menu}
{component breadcrumbs}
{component someMyComponent}
```


## Typed templates

```php
class Breadcrumbs implements SimpleComponents\Component
{
	/** @var BreadcrumbItem[] */
	private $items;


	/**
	 * @param BreadcrumbItem[] $items
	 */
	public function __construct(array $items)
	{
		$this->items = $items;
	}


	public function getFile()
	{
		return __DIR__ . '/components/breadcrumbs.latte';
	}


	public function getParameters()
	{
		return [
			'items' => $this->items;
		];
	}
}


class MyComponentFactory implements SimpleComponents\ComponentFactory
{
	public function create($componentName, array $args = [])
	{
		if ($componentName === 'breadcrumbs') {
			return new Breadcrumbs($args['items']);
		}

		return NULL;
	}
}
```

```latte
{component breadcrumbs, items => $breadcrumbsItems}
```


------------------------------

License: [New BSD License](license.md)
<br>Author: Jan Pecha, https://www.janpecha.cz/
