<?php

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
