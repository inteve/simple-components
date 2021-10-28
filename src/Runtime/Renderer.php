<?php

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
			SimpleComponents\IComponents $components,
			callable $templateRenderer,
			$componentName,
			array $args = []
		)
		{
			$template = $components->createTemplate($componentName, $args);

			if ($template === NULL) {
				throw new \Inteve\SimpleComponents\InvalidStateException("Component '$componentName' not found.");

			} else {
				$templateRenderer($template);
			}
		}
	}
