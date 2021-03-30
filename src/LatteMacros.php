<?php

	namespace Inteve\SimpleComponents;

	use Latte;
	use Latte\Compiler;
	use Latte\Macros\MacroSet;


	class LatteMacros extends MacroSet
	{
		/**
		 * @return self
		 */
		public static function install(Compiler $compiler)
		{
			$me = new self($compiler);
			$me->addMacro('component', '$this->global->inteveComponents->createAndRender(%node.word, %node.array, $this->global->uiControl)');
			return $me;
		}


		/**
		 * @return void
		 */
		public static function installToLatte(Latte\Engine $latte, Components $components)
		{
			$latte->addProvider('inteveComponents', $components);
			self::install($latte->getCompiler());
		}
	}
