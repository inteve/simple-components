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
			$me->addMacro('component', '$this->global->inteve_simpleComponents->createAndRender(%node.word, %node.array, isset($this->global->uiControl) ? $this->global->uiControl : NULL)');
			return $me;
		}


		/**
		 * @return void
		 */
		public static function installToLatte(Latte\Engine $latte, Components $components)
		{
			$latte->addProvider('inteve_simpleComponents', $components);
			self::install($latte->getCompiler());
		}
	}
