<?php

namespace App\Enum;

enum MatchPoints: int
{
    case QUARTER_FINALS = 100;
    case SEMI_FINALS = 150;
    case THIRD_PLACE = 200;
    case FINAL = 250;
    case WIN = 50;
    case LOSS = 25;

    public static function getStagePoints(): array
    {
        return [
            "quarter_finals" => self::QUARTER_FINALS->value,
            "semi_finals" => self::SEMI_FINALS->value,
            "third_place" => self::THIRD_PLACE->value,
            "final" => self::FINAL->value,
            "win" => self::WIN->value,
            "loss" => self::LOSS->value
        ];
    }
}
