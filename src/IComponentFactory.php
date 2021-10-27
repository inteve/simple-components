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
		 * @return ITemplate|NULL
		 */
		function createTemplate(array $args);
	}
