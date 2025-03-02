<?php

namespace App\Repository;

use App\Entity\Divisions;
use App\Repository\TeamsRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @extends ServiceEntityRepository<Divisions>
 */
class DivisionsRepository extends ServiceEntityRepository
{
    private TeamsRepository $teamsRepository;
    private EntityManagerInterface $em;
    public function __construct(ManagerRegistry $registry, TeamsRepository $teamsRepository, EntityManagerInterface $em)
    {
        parent::__construct($registry, Divisions::class);
        $this->teamsRepository = $teamsRepository;
        $this->em = $em;
    }


    public function getDivisionsName(?string $divisionName = null): array
    {
        $divisionName = $divisionName !== null ? str_replace("_", " ", $divisionName) : null;
        return match (empty($divisionName)) {
            true => $this->em->getRepository(Divisions::class)->findBy([], ['id' => 'ASC']),
            false => $this->em->getRepository(Divisions::class)->findBy(['DivisionName' => $divisionName], ['id' => 'ASC']),
        };
    }

    public function getDivisionWithLessTeams(array $divisionNames): Divisions
    {
        $counts = [];

        foreach ($divisionNames as $division) {
            $divisionName = $division->getDivisionName();

            if ($divisionName === 'Playoff') {
                continue;
            }

            $counts[$divisionName] = $this->teamsRepository->countTeamsInDivision($divisionName);
        }

        if (empty($counts)) {
            throw new \Exception('No divisions found for the given criteria.');
        }

        asort($counts);

        $bestDivisionName = array_key_first($counts);

        foreach ($divisionNames as $division) {
            if ($division->getDivisionName() === $bestDivisionName) {
                return $division;
            }
        }

        throw new \Exception('No division found with the least number of teams.');
    }


    public function clearDivisions(): void
    {
        $qb = $this->createQueryBuilder('e')
            ->delete()
            ->getQuery();
        $qb->execute();
    }

    public function saveDivision(Divisions $division): bool
    {
        try {
            $this->em->persist($division);
            $this->em->flush();
        } catch (\Exception $e) {
            throw new \RuntimeException("Ошибка при сохранении дивизии: " . $e->getMessage(), 0, $e);
        }

        return true;
    }
}
