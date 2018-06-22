<?php

namespace App\Models\Traits;

use RandomLib\Factory;
use SecurityLib\Strength;

trait TicketTrait
{
	public function generate($count = 0)
	{
		$factory   = new Factory;
        $generator = $factory->getGenerator(new Strength(Strength::MEDIUM));

        $pattern = '123456789abcdefghijklmnpqrstuvwxyz';

        $lists = [];
        while ($count > 0) {
            $randomString = $generator->generateString(10, $pattern);
            if (in_array($randomString, $lists)) {
                continue;
            } else {
                array_push($lists, $randomString);
                $count--;
            }
        }
        return $lists;
	}
}
