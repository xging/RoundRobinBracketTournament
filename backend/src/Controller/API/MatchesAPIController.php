<?php

namespace App\Controller\API;

use App\Common\DTO\MatchDTO;
use App\Controller\API\BaseApiController;
use App\Repository\MatchesRepository;
use App\Repository\TeamsRepository;
use App\Repository\TeamsResultsRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Predis\Client as RedisClient;
use App\Common\Traits\CacheTrait;

#[Route('/api/matches', name: 'api_matches')]
class MatchesAPIController extends BaseApiController
{
    use CacheTrait;

    public function __construct(
        private MatchesRepository $matchesRepository,
        private TeamsRepository $teamsRepository,
        private TeamsResultsRepository $teamsResultsRepository,
        RedisClient $redis
    ) {
        $this->setRedisClient($redis);
    }

    #[Route('', name: 'list', methods: ['GET'])]
    public function list(): Response
    {
        $matches = $this->matchesRepository->getAllMatches();
        $groupedMatches = [];

        foreach ($matches as $match) {
            $stage = $match->getStage();
            if (!isset($groupedMatches[$stage])) {
                $groupedMatches[$stage] = [];
            }
            // $groupedMatches[$stage][] = new MatchDTO($match);
            $groupedMAtches[$stage][] = MatchDTO::fromMatch($match);
        }

        return $this->jsonSuccess($groupedMatches);
    }

    #[Route('/all', name: 'showMatches', methods: ['GET'])]
    public function showMatches(): Response
    {
        $res = $this->getCache('Matches');

        if (empty($res)) {
            $res = $this->matchesRepository->getAllMatches();
            $this->setCache('Matches', $res);
        }

        return $this->render('matches/matches.html.twig', [
            'matches' => $res,
        ]);
    }

    #[Route('/teams', name: 'showTeams', methods: ['GET'])]
    public function showTeams(): Response
    {
        $teams = $this->teamsRepository->getTeamNamesGroupedByDivisions();
        return $this->jsonSuccess($teams);
    }

    #[Route('/results_{count}', name: 'showTeams', methods: ['GET'])]
    public function showResults($count): Response
    {
        if ($count < 1 || $count > 20) {
            return $this->jsonError('Result value should be between 1 and 20');
        }

        $teamsResults = $this->teamsResultsRepository->getTeamsResults($count);
        return $this->render('teams/results.html.twig', [
            'teams_results' => $teamsResults,
        ]);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(int $id): Response
    {
        $match = $this->matchesRepository->getMatchById($id);
        if (!$match) {
            return $this->jsonError("Match with ID $id not found", Response::HTTP_NOT_FOUND);
        }

        return $this->jsonSuccess([$match->getStage() => [MatchDTO::fromMatch($match)]]);
    }
}
