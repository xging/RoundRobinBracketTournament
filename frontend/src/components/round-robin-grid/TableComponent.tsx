import React from "react";
import TableHeader from "./TableHeader";
import TableBody from "./TableBody";

const TableComponent = ({ teams }: { teams: string[] }) => {
    return (
      <table className="w-full border border-gray-300 text-center">
        <TableHeader teams={teams} />
        <TableBody teams={teams} />
      </table>
    );
  };

export default TableComponent;
