<?php

namespace App\Services\TeamGenerator;

use App\Entity\Teams;
use App\Services\TeamGenerator\Interface\DivisionAssignerInterface;
use App\Repository\DivisionsRepository;

class DivisionAssigner implements DivisionAssignerInterface
{
    private DivisionsRepository $divisionsRepository;

    public function __construct(
        DivisionsRepository $divisionsRepository
    ) {
        $this->divisionsRepository = $divisionsRepository;
    }

    public function assign(Teams $team): void
    {
        $selectedDivisionName = $this->divisionsRepository->getDivisionsName();
        $suitableDivisionName = $this->divisionsRepository->getDivisionWithLessTeams($selectedDivisionName);
        $team->setDivisionName($suitableDivisionName->getDivisionName());
    }
}
