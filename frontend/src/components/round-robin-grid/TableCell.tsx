import React from "react";
import { matches } from "./MatchData";

const TableCell = ({ teamA, teamB, rowIndex, colIndex }: { teamA: string; teamB: string; rowIndex: number; colIndex: number }) => {
    const match = matches.find(m =>
      (m.teamA === teamA && m.teamB === teamB) ||
      (m.teamA === teamB && m.teamB === teamA)
    );
    let cellContent = rowIndex === colIndex ? "X" : "-";
    if (match) {
      cellContent = match.teamA === teamA ? `${match.scoreA}-${match.scoreB}` : `${match.scoreB}-${match.scoreA}`;
    }
  
    return (
      <td className={`p-2 border ${teamA === teamB ? 'bg-gray-300' : ''}`}>{cellContent}</td>
    );
  };
  

export default TableCell;
