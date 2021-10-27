<?php

	namespace Inteve\SimpleComponents;

	use Latte;


	class LatteMacros extends Latte\Macros\MacroSet
	{
		/**
		 * @return void
		 */
		public static function install(Latte\Compiler $compiler)
		{
			$me = new self($compiler);
			$me->addMacro('component', [$me, 'macroComponent']);
		}


		/**
		 * @return void
		 */
		public static function installToLatte(Latte\Engine $latte, IComponents $components)
		{
			$latte->addProvider('inteve_simpleComponents', $components);
			self::install($latte->getCompiler());
		}


		/**
		 * {component "name" [,] [params]}
		 * @return string
		 */
		public function macroComponent(Latte\MacroNode $node, Latte\PhpWriter $writer)
		{
			$node->validate(TRUE, [], FALSE);
			$node->replaced = FALSE;

			return $writer->write(
				'\Inteve\SimpleComponents\Runtime\Renderer::tryRender($this, %raw, %node.word, %node.array);',
				Latte\PhpHelpers::dump(implode($node->context))
			);
		}
	}
