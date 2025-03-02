import React from "react";
import TableCell from "./TableCell";

const TableBody = ({ teams }: { teams: string[] }) => {
    return (
      <tbody>
        {teams.map((teamA, rowIndex) => (
          <tr key={rowIndex}>
            <td className="p-2 border font-bold">{teamA}</td>
            {teams.map((teamB, colIndex) => (
              <TableCell key={`cell-${rowIndex}-${colIndex}`} teamA={teamA} teamB={teamB} rowIndex={rowIndex} colIndex={colIndex} />
            ))}
          </tr>
        ))}
      </tbody>
    );
  };

export default TableBody;
