import React from "react";

const TableHeader = ({ teams }: { teams: string[] }) => {
    return (
      <thead>
        <tr className="bg-gray-200">
          <th className="p-2 border"></th>
          {teams.map((team, index) => (
            <th key={index} className="p-2 border">{team}</th>
          ))}
        </tr>
      </thead>
    );
  };

export default TableHeader;
