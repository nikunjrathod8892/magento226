<?php

namespace Brainvire\Wholesaler\Model;

/**
 * 
 */
class Wholesalerstatus
{
	
	const PENDING = 0;
	const APPROVED = 1;
	const DISAPPROVED = 2;

	const PENDING_TEXT = 'Pending';
	const APPROVED_TEXT = 'Approved';
	const DISAPPROVED_TEXT = 'Disapproved';

	function toArray()
	{
		$array = array();
		$array[self::PENDING] = self::PENDING_TEXT;
		$array[self::APPROVED] = self::APPROVED_TEXT;
		$array[self::DISAPPROVED] = self::DISAPPROVED_TEXT;

		return $array;
	}
}