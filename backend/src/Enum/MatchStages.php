<?php

namespace App\Enum;

enum MatchStages: string
{
    case QUARTER_FINALS = 'quarter_finals';
    case SEMI_FINALS = 'semi_finals';
    case THIRD_PLACE = 'third_place';
    case FINAL = 'final';
    case MAIN_STAGE = 'Main Stage';
}
