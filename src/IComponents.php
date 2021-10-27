<?php

	namespace Inteve\SimpleComponents;


	interface IComponents
	{
		/**
		 * @param  string $componentName
		 * @param  array<string, mixed> $args
		 * @return ITemplate|NULL
		 */
		function createTemplate($componentName, array $args = []);
	}
