<?php

namespace App\Controller\API;

use App\Controller\API\BaseApiController;
use App\Repository\MatchesRepository;
use App\Services\Interface\BuildTournamentInterface;
use App\Services\Interface\MatchInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

#[Route('/api/tournament', name: 'api_tournament')]
class TournamentController extends BaseApiController
{
    private BuildTournamentInterface $buildTournament;
    private MatchesRepository $matchesRepository;
    private MatchInterface $match;

    public function __construct(
        BuildTournamentInterface $buildTournament,
        MatchesRepository $matchesRepository,
        MatchInterface $match
    ) {
        $this->buildTournament = $buildTournament;
        $this->matchesRepository = $matchesRepository;
        $this->match = $match;
    }
    #[Route('', name: 'build', methods: ['GET'])]
    public function build(): Response
    {
        $this->buildTournament->build();
        return $this->jsonSuccess(['status' => 'Tournament built successfully']);
    }

    #[Route('/start-match/{divisionName}', name: 'startMatch', methods: ['GET'])]
    public function startMatch(string $divisionName): Response
    {
        $notPlayedMatchesCount = $this->matchesRepository->getNotPlayedMatchesCount(str_replace("_", " ", $divisionName));
        if ($notPlayedMatchesCount === 0) {
            return $this->jsonError('No matches found for processing.');
        }

        $this->match->start($notPlayedMatchesCount, $divisionName);
        return $this->jsonSuccess(['status' => 'Matches started.']);
    }
}
