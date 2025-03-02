<?php

namespace App\Repository;

use App\Entity\Divisions;
use App\Entity\Teams;
use App\Entity\TeamsResults;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @extends ServiceEntityRepository<Teams>
 */
class TeamsRepository extends ServiceEntityRepository
{
    private EntityManagerInterface $em;
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $em)
    {
        parent::__construct($registry, Teams::class);
        $this->em = $em;
    }



    public function getPlayoffTeams(): array
    {
        $divisions = $this->em->getRepository(Teams::class)
            ->createQueryBuilder('t')
            ->select('DISTINCT t.DivisionName')
            ->join(TeamsResults::class, 'tr', 'WITH', 'tr.teamName = t.TeamName')
            ->getQuery()
            ->getResult();

        $teams = [];

        foreach ($divisions as $division) {
            $divisionName = $division['DivisionName'];

            $qb = $this->em->createQueryBuilder();
            $query = $qb->select('t, tr.divisionName')
                ->from(TeamsResults::class, 'tr')
                ->join(Teams::class, 't', 'WITH', 'tr.teamName = t.TeamName')
                ->where('t.DivisionName = :division')
                ->orderBy('tr.points', 'DESC')
                ->addOrderBy('tr.difference', 'DESC')
                ->addOrderBy('tr.goalScored', 'DESC')
                ->setMaxResults(4)
                ->setParameter('division', $divisionName)
                ->getQuery()
                ->getResult();

            $teams = array_merge($teams, $query);
        }

        return $teams;
    }

    public function getTeamsListName(): array
    {
        return $this->em->getRepository(Teams::class)->findAll();
    }

    public function getTeamNamesGroupedByDivisions(): array
    {
        $teams = $this->em->getRepository(Teams::class)->createQueryBuilder('m')
            ->select('m.TeamName, m.DivisionName')
            ->getQuery()
            ->getResult();

        $groupedTeams = [];
        foreach ($teams as $team) {
            $groupedTeams[$team['DivisionName']][] = $team['TeamName'];
        }

        return $groupedTeams;
    }

    public function countTeamsInDivision(string $divisionName): int
    {
        return $this->em->getRepository(Teams::class)
            ->count(['DivisionName' => $divisionName]);
    }

    public function ifTeamExists(string $name): bool
    {
        return (bool) $this->em->getRepository(Teams::class)->count(['TeamName' => $name]);
    }

    public function clearTeams(): void
    {
        $qb = $this->createQueryBuilder('e')
            ->delete()
            ->getQuery();
        $qb->execute();
    }


    public function saveTeam(Teams $team): void
    {
        try {
            $this->em->persist($team);
            $this->em->flush();
        } catch (\Exception $e) {
            throw new \RuntimeException("Ошибка при сохранении команды: " . $e->getMessage(), 0, $e);
        }
    }
}
