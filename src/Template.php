<?php

	namespace Inteve\SimpleComponents;


	class Template
	{
		/** @var string */
		private $file;

		/** @var array<string, mixed> */
		private $parameters;


		/**
		 * @param string $file
		 * @param array<string, mixed> $parameters
		 */
		public function __construct($file, array $parameters)
		{
			$this->file = $file;
			$this->parameters = $parameters;
		}


		/**
		 * @return string
		 */
		public function getFile()
		{
			return $this->file;
		}


		/**
		 * @return array<string, mixed>
		 */
		public function getParameters()
		{
			return $this->parameters;
		}
	}
