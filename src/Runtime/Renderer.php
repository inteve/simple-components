<?php

	namespace Inteve\SimpleComponents\Runtime;

	use Latte;


	class Renderer
	{
		public function __construct()
		{
			throw new \Inteve\SimpleComponents\StaticClassException('This is static class.');
		}


		/**
		 * @param  string|\Closure|null  $contentType  content-type name or modifier closure
		 * @param  string $componentName
		 * @param  array<string, mixed> $args
		 * @return void
		 */
		public static function tryRender(
			Latte\Runtime\Template $latteTemplate,
			$contentType,
			$componentName,
			array $args = []
		)
		{
			$template = $latteTemplate->global->inteve_simpleComponents->createTemplate($componentName, $args);

			if ($template === NULL) {
				throw new \Inteve\SimpleComponents\InvalidStateException("Component '$componentName' not found.");

			} else {
				$latteTemplate->createTemplate($template->getFile(), $template->getParameters(), 'include')->renderToContentType($contentType);
			}
		}
	}
