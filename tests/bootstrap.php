<?php

require __DIR__ . '/../vendor/autoload.php';

Tester\Environment::setup();


function test($title, callable $cb)
{
	$cb();
}


function saveOutput(callable $cb)
{
	try {
		ob_start();
		$cb();
		$res = ob_get_contents();
		ob_end_clean();
		return $res;

	} catch (\Exception $e) {
		ob_end_clean();
		throw $e;

	} catch (\Throwable $e) {
		ob_end_clean();
		throw $e;
	}
}
