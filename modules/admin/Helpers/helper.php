<?php 

namespace Modules\Admin\Helpers;

class CamelCase
{

	public static function index()
	{

		$args = func_get_args();

		$input = $args[0];

		unset($args[0]);

		foreach ($args as $input_field) {
			$input[$input_field] = ucwords($input[$input_field]);

		}

		return $input;
	}

}









?>