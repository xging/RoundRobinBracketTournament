"use client";
import React, { useState, useEffect } from "react";
import { matches } from "./MatchData";
import DropdownComponent from "./Dropdown";
import TableComponent from "./TableComponent";

const TournamentGrid = () => {
  const [division, setDivision] = useState("Division A");
  const [teams, setTeams] = useState<string[]>([]);

  useEffect(() => {
    const getTeams = (division: string) => {
      const teamSet = new Set<string>();
      matches.forEach(match => {
        if (match.division === division) {
          teamSet.add(match.teamA);
          teamSet.add(match.teamB);
        }
      });
      return Array.from(teamSet);
    };

    setTeams(getTeams(division));
  }, [division]);

  return (
    <div className="p-6 max-w-6xl mx-auto">
      <DropdownComponent division={division} setDivision={setDivision} />
      <h2 className="text-2xl font-bold mb-4">Round Robin Table</h2>
      <TableComponent teams={teams} />
    </div>
  );
};

export default TournamentGrid;
