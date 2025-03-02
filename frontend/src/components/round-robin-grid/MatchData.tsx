// components/MatchData.ts
export type Match = {
    id: number;
    division: string;
    teamA: string;
    teamB: string;
    scoreA: number;
    scoreB: number;
  };
  
  const generateMatches = (division: string, teams: string[]): Match[] => {
    const matches: Match[] = [];
    for (let i = 0; i < teams.length; i++) {
      for (let j = i + 1; j < teams.length; j++) {
        matches.push({
          id: matches.length + 1,
          division,
          teamA: teams[i],
          teamB: teams[j],
          scoreA: Math.floor(Math.random() * 5),
          scoreB: Math.floor(Math.random() * 5),
        });
      }
    }
    return matches;
  };
  
  export const matches: Match[] = [
    ...generateMatches("Division A", [
      "Village 1", "Village 2", "Village 3", "Village 4", "Village 5",
      "Village 6", "Village 7", "Village 8", "Village 9", "Village 10"
    ]),
    ...generateMatches("Division B", [
      "Village 11", "Village 12", "Village 13", "Village 14", "Village 15",
      "Village 16", "Village 17", "Village 18", "Village 19", "Village 20"
    ])
  ];
  