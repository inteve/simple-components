<?php

	namespace Inteve\SimpleComponents;

	use Nette\Application\UI;


	class Components
	{
		/** @var UI\ITemplateFactory */
		private $templateFactory;

		/** @var array<string, IComponentFactory> */
		private $factories = [];


		/**
		 * @param IComponentFactory[] $factories
		 */
		public function __construct(
			array $factories,
			UI\ITemplateFactory $templateFactory
		)
		{
			$this->templateFactory = $templateFactory;

			foreach ($factories as $factory) {
				$this->addFactory($factory);
			}
		}


		/**
		 * @return void
		 */
		public function addFactory(IComponentFactory $factory)
		{
			$name = $factory->getName();

			if (isset($this->factories[$name])) {
				throw new InvalidStateException("Factory '$name' already exists.");
			}

			$this->factories[$name] = $factory;
		}


		/**
		 * @param  string $name
		 * @param  array<string, mixed> $args
		 * @return void
		 */
		public function createAndRender($name, array $args = [], UI\Control $control = NULL)
		{
			if (!isset($this->factories[$name])) {
				throw new InvalidStateException("Missing factory for component '$name'.");
			}

			$componentTemplate = $this->factories[$name]->createTemplate($args);

			if ($componentTemplate === NULL) {
				return;
			}

			$template = $this->templateFactory->createTemplate($control);
			$template->render($componentTemplate->getFile(), $componentTemplate->getParameters());
		}
	}
