<?php

	declare(strict_types=1);

	namespace Inteve\SimpleComponents\Runtime;

	use Inteve\SimpleComponents;
	use Latte;


	class Renderer
	{
		public function __construct()
		{
			throw new \Inteve\SimpleComponents\StaticClassException('This is static class.');
		}


		/**
		 * @param  string $componentName
		 * @param  array<string, mixed> $args
		 * @return void
		 */
		public static function tryRender(
			SimpleComponents\ComponentFactory $componentFactory,
			callable $templateRenderer,
			$componentName,
			array $args = []
		)
		{
			$component = $componentFactory->create($componentName, $args);

			if ($component === NULL) {
				throw new \Inteve\SimpleComponents\InvalidStateException("Component '$componentName' not found.");

			} else {
				$templateRenderer($component);
			}
		}
	}
