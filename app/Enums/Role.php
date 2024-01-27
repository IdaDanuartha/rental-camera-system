<?php

namespace App\Enums;

enum Role: int
{
	case ADMIN = 0;
	case STAFF = 1;
	case CUSTOMER = 2;

	public function label()
	{
		return match ($this) {
			self::ADMIN => 'Admin',
			self::STAFF => 'Staff',
			self::CUSTOMER => 'Customer',
		};
	}
}
