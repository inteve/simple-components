<?php

	declare(strict_types=1);

	namespace Inteve\SimpleComponents;


	interface Component
	{
		/**
		 * @return string
		 */
		function getFile();


		/**
		 * @return array<string, mixed>
		 */
		function getParameters();
	}
