<?php

namespace App\Services\TeamGenerator\Interface;

use App\Entity\Teams;

interface DivisionAssignerInterface
{
    public function assign(Teams $team): void;
}
