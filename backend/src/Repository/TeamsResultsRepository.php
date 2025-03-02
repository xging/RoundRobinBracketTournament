<?php

namespace App\Repository;

use App\DTO\MatchResultDTO;
use App\Entity\Teams;
use App\Entity\TeamsResults;
use App\Enum\MatchPoints;
use App\Enum\MatchStages;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TeamsResults>
 */
class TeamsResultsRepository extends ServiceEntityRepository
{
    private EntityManagerInterface $em;
    private $InitialStage;
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $em)
    {
        parent::__construct($registry, TeamsResults::class);
        $this->em = $em;
        $this->InitialStage = MatchStages::MAIN_STAGE->value;
    }



    public function addTeamResults(TeamsResults $teamResults): bool
    {
        try {
            $this->em->persist($teamResults);
            $this->em->flush();
        } catch (\Exception $e) {
            throw new \RuntimeException("Ошибка при добавлении команды в таблицу результатов: " . $e->getMessage(), 0, $e);
        }

        return true;
    }

    public function getTeamsResults($count): array
    {
        $teams = $this->em->getRepository(TeamsResults::class)->createQueryBuilder('tr')
            ->select('tr.divisionName, tr.teamName, tr.matches, tr.wins, tr.loss, tr.ties, tr.goalScored, tr.goalConceded, tr.difference, tr.points')
            ->orderBy('tr.matches', 'DESC')
            ->addOrderBy('tr.points', 'DESC')
            ->addOrderBy('tr.difference', 'DESC')
            ->addOrderBy('tr.goalScored', 'DESC')
            ->setMaxResults($count);

        $results = $teams->getQuery()->getResult();

        if (empty($results)) {
            return ['message' => 'No results found'];
        }

        return $results;
    }

    public function clearTeamsResults(): void
    {
        $qb = $this->createQueryBuilder('e')
            ->delete()
            ->getQuery();
        $qb->execute();
    }

    public function saveTeamResult(TeamsResults $teamsResults): void
    {
        try {
            $this->em->persist($teamsResults);
            $this->em->flush();
        } catch (\Exception $e) {
            throw new \RuntimeException("Ошибка при сохранении команды: " . $e->getMessage(), 0, $e);
        }
    }
}
