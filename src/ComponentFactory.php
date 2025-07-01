<?php

	declare(strict_types=1);

	namespace Inteve\SimpleComponents;


	interface ComponentFactory
	{
		/**
		 * @param  string $componentName
		 * @param  array<string, mixed> $args
		 * @return Component|NULL
		 */
		function create($componentName, array $args = []);
	}
