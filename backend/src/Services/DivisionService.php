<?php

namespace App\Services;

use App\Entity\Divisions;
use App\Enum\DivisionsList;
use App\Repository\DivisionsRepository;
use App\Services\DivisionGenerator\Interface\DivisionNameGeneratorInterface;
use App\Services\Interface\DivisionInterface;

class DivisionService implements DivisionInterface
{
    public function __construct(
        private DivisionNameGeneratorInterface $nameGenerator,
        private DivisionsRepository $divisionRepository
    ) {}

    public function createDivision(string $name): void
    {
        $divisionsList = DivisionsList::getDivisions();

        foreach ($divisionsList as $divisions) {
            $division = new Divisions;
            $division->setDivisionName(str_replace("_", " ", $divisions));
            $this->divisionRepository->saveDivision($division);
        }
    }
}
