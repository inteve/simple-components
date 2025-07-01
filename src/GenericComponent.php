<?php

	declare(strict_types=1);

	namespace Inteve\SimpleComponents;


	class GenericComponent implements Component
	{
		/** @var string */
		private $file;

		/** @var array<string, mixed> */
		private $parameters;


		/**
		 * @param string $file
		 * @param array<string, mixed> $parameters
		 */
		public function __construct($file, array $parameters = [])
		{
			$this->file = $file;
			$this->parameters = $parameters;
		}


		public function getFile()
		{
			return $this->file;
		}


		public function getParameters()
		{
			return $this->parameters;
		}
	}
