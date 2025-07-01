<?php

	declare(strict_types=1);

	namespace Inteve\SimpleComponents;


	class DirectoryFactory implements ComponentFactory
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


		public function create($componentName, array $args = [])
		{
			$path = $this->directory . '/' . $componentName . '.latte';

			if (is_file($path)) {
				return new GenericComponent($path, $args);
			}

			return NULL;
		}
	}
