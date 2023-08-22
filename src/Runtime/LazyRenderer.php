<?php

	namespace Inteve\SimpleComponents\Runtime;

	use Inteve\SimpleComponents;
	use Latte;


	class LazyRenderer implements Latte\Runtime\IHtmlString
	{
		/** @var Latte\Engine */
		private $latte;

		/** @var SimpleComponents\ComponentFactory */
		private $componentFactory;

		/** @var string */
		private $componentName;

		/** @var array<string, mixed> */
		private $args;


		/**
		 * @param  string $componentName
		 * @param  array<string, mixed> $args
		 */
		public function __construct(
			Latte\Engine $latte,
			SimpleComponents\ComponentFactory $componentFactory,
			$componentName,
			array $args = []
		)
		{
			$this->latte = $latte;
			$this->componentFactory = $componentFactory;
			$this->componentName = $componentName;
			$this->args = $args;
		}


		public function __toString()
		{
			$component = $this->componentFactory->create($this->componentName, $this->args);

			if ($component === NULL) {
				throw new \Inteve\SimpleComponents\InvalidStateException("Component '$this->componentName' not found.");
			}

			return $this->latte->renderToString(
				$component->getFile(),
				$component->getParameters()
			);
		}
	}
