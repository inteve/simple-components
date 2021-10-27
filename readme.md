
# Inteve\SimpleComponents

[![Tests Status](https://github.com/inteve/simple-components/workflows/Tests/badge.svg)](https://github.com/inteve/simple-components/actions)

Simple independent components for Latte templates.

<a href="https://www.paypal.me/janpecha/5eur"><img src="https://buymecoffee.intm.org/img/button-paypal-white.png" alt="Buy me a coffee" height="35"></a>


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


class MyComponents implements SimpleComponents\IComponents
{
	public function createTemplate($componentName, array $args = [])
	{
		if ($componentName === 'menu') {
			return new SimpleComponents\Template(__DIR__ . '/components/Menu.latte');

		} elseif ($componentName === 'breadcrumbs') {
			return new SimpleComponents\Template(__DIR__ . '/components/Breadcrumbs.latte', $args);
		}

		return NULL;
	}
}
```


### 2. register `{component}` macro

```php
$latte = new Latte\Engine;
$components = new MyComponents;
\Inteve\SimpleComponents\LatteMacros::installToLatte($latte, $components);
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

### `DirectoryComponents`

Loads template files from specified directory.

```
/app
	/components
		breadcrumbs.latte
		menu.latte
```

```php
$components = new SimpleComponents\DirectoryComponents('/path/to/app/components');
```

```latte
{component menu}
{component breadcrumbs}
```


### `MultiComponents`

Packs multiple `IComponents` implementations to one class.

```php
$components = new SimpleComponents\MultiComponents([
	new MyComponents,
	new SimpleComponents\DirectoryComponents('/path/to/app/components')
]);
```

```latte
{component menu}
{component breadcrumbs}
{component someMyComponent}
```


## Typed templates

```php
class BreadcrumbsTemplate implements SimpleComponents\ITemplate
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


class MyComponents implements SimpleComponents\IComponents
{
	public function createTemplate($componentName, array $args = [])
	{
		if ($componentName === 'breadcrumbs') {
			return new BreadcrumbsTemplate($args['items']);
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
