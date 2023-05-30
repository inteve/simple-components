<?php

	namespace Inteve\SimpleComponents;


	class MultiFactory implements ComponentFactory
	{
		/** @var ComponentFactory[] */
		private $factories;


		/**
		 * @param ComponentFactory[] $factories
		 */
		public function __construct(array $factories)
		{
			$this->factories = $factories;
		}


		public function create($componentName, array $args = [])
		{
			foreach ($this->factories as $components) {
				$component = $components->create($componentName, $args);

				if ($component !== NULL) {
					return $component;
				}
			}

			return NULL;
		}
	}
