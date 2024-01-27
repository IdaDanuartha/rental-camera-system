<?php

namespace App\Enums;

enum UserStatus: int
{
	case ACTIVE = 0;
	case NONACTIVE = 1;

	public function label()
	{
		return match ($this) {
			self::ACTIVE => 'Active',
			self::NONACTIVE => 'Disabled',
		};
	}

	public static function labels(): array
	{
		return [
			'Active',
			'Disabled',
		];
	}
}
