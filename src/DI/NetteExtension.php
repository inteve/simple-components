<?php

	namespace Inteve\SimpleComponents\DI;

	use Nette;


	class NetteExtension extends Nette\DI\CompilerExtension
	{
		public function loadConfiguration()
		{
			$builder = $this->getContainerBuilder();

			$builder->addDefinition($this->prefix('components'))
				->setFactory(\Inteve\SimpleComponents\Components::class);
		}
	}
