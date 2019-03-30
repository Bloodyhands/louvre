<?php

namespace App\Service;

class RandomString
{
	public function generateRandomString($length, $list = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
	{
		$string = '';
		$max = mb_strlen($list, '8bit') - 1;
		for ($i = 0; $i < $length; $i++){
				$string .= $list[random_int(0, $max)];
		}

		return $string;
	}
}