<?php

	namespace Inteve\SimpleComponents;


	interface ITemplate
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
