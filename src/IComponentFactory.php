<?php

	namespace Inteve\SimpleComponents;


	interface IComponentFactory
	{
		/**
		 * @return string
		 */
		function getName();


		/**
		 * @param  array<string, mixed> $args
		 * @return Template|NULL
		 */
		function createTemplate(array $args);
	}
