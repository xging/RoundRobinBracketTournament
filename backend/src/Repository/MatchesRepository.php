<?php

namespace App\Repository;

use App\Common\DTO\MatchResultDTO;
use App\Entity\Matches;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Monolog\Attribute\WithMonologChannel;
use Psr\Log\LoggerInterface;

/**
 * @extends ServiceEntityRepository<Matches>
 */
#[WithMonologChannel('cache_log')]
class MatchesRepository extends ServiceEntityRepository
{

    private EntityManagerInterface $em;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $em, private LoggerInterface $logger)
    {
        parent::__construct($registry, Matches::class);
        $this->em = $em;
    }

    public function getLastPlayedMatches(int $limit = 1): array
    {
        return $this->em->getRepository(Matches::class)->findBy([], ['id' => 'DESC'], $limit);
    }

    public function getAllMatches(): array
    {
        return $this->em->getRepository(Matches::class)->findBy([], ['Division' => 'ASC']);
    }


    public function getMatchById(int $id): ?Matches
    {
        return $this->em->getRepository(Matches::class)->find($id);
    }

    public function getNotPlayedMatch($division): Matches|false
    {
        $match = $this->em->getRepository(Matches::class)->findOneBy(['isPlayed' => false, 'Division' => $division]);
        return $match ?? false;
    }

    public function getNotPlayedMatchesInStageCount($stageName): int
    {
        $match = $this->em->getRepository(Matches::class)->findBy(['isPlayed' => false, 'Stage' => $stageName]);
        return count($match);
    }

    public function getNotPlayedMatchesCount(?string $divisionName): int
    {
        $match = $this->em->getRepository(Matches::class)->findBy(['isPlayed' => false, 'Division' => $divisionName]);
        return count($match);
    }

    public function updateMatchOpponent(string $team1, string $team2): Matches
    {
        $match = $this->em->getRepository(Matches::class)->findOneBy(['Team_A' => $team1, 'Team_B' => "waiting_for_opponent", 'isPlayed' => false]);
        $match->setTeamB($team2);
        $this->em->persist($match);
        $this->em->flush();

        return $match;
    }

    public function clearMatches(): void
    {
        $qb = $this->createQueryBuilder('e')
            ->delete()
            ->getQuery();
        $qb->execute();
    }

    public function saveMatch(Matches $match): Matches
    {
        try {
            $this->em->persist($match);
            $this->em->flush();
        } catch (\Exception $e) {
            throw new \RuntimeException("Ошибка при сохранении или создании матча: " . $e->getMessage(), 0, $e);
        }

        return $match;
    }
}
