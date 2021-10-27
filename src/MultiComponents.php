<?php

	namespace Inteve\SimpleComponents;


	class MultiComponents implements IComponents
	{
		/** @var IComponents[] */
		private $components;


		/**
		 * @param IComponents[] $components
		 */
		public function __construct(array $components)
		{
			$this->components = $components; // TODO: array_reverse()?
		}


		public function createTemplate($componentName, array $args = [])
		{
			foreach ($this->components as $components) {
				$template = $components->createTemplate($componentName, $args);

				if ($template !== NULL) {
					return $template;
				}
			}

			return NULL;
		}
	}
