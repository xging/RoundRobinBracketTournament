<?php

namespace App\Common\Enum;

enum DivisionsList: string
{
    case DIVISION_A = 'Division A';
    case DIVISION_B = 'Division B';
    case PLAYOFF_DIVISION = 'Playoff';

    public static function getDivisions(): array
    {
        return [
            self::DIVISION_A->value,
            self::DIVISION_B->value,
            self::PLAYOFF_DIVISION->value,
        ];
    }
}
