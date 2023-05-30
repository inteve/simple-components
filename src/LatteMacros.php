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
		public static function installToLatte(Latte\Engine $latte, ComponentFactory $components)
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
			// $node->validate(TRUE, [], FALSE);
			if ($node->args === '') {
				throw new InvalidStateException('Missing arguments in {component} macro.');
			}

			if ($node->modifiers !== '') {
				throw new InvalidStateException('Filters are not allowed in {component} macro.');
			}

			$node->replaced = FALSE;

			return $writer->write(
				'\Inteve\SimpleComponents\Runtime\Renderer::tryRender($this->global->inteve_simpleComponents, function ($component) { $this->createTemplate($component->getFile(), $component->getParameters(), \'include\')->renderToContentType(%raw); }, %node.word, %node.array);',
				Latte\PhpHelpers::dump(implode($node->context))
			);
		}
	}
