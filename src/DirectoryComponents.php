<?php

	namespace Inteve\SimpleComponents;


	class DirectoryComponents implements IComponents
	{
		/** @var string */
		private $directory;


		/**
		 * @param string $directory
		 */
		public function __construct($directory)
		{
			$this->directory = $directory;
		}


		public function createTemplate($componentName, array $args = [])
		{
			$path = $this->directory . '/' . $componentName . '.latte';

			if (is_file($path)) {
				return new Template($path, $args);
			}

			return NULL;
		}
	}
