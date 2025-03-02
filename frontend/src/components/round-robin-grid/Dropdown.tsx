"use client";
import React from "react";

interface DropdownProps {
  division: string;
  setDivision: (division: string) => void;
}

const Dropdown: React.FC<DropdownProps> = ({ division, setDivision }) => {
  return (
    <select
      className="form-select mb-3"
      value={division}
      onChange={(e) => setDivision(e.target.value)}
    >
      <option value="Division A">Division A</option>
      <option value="Division B">Division B</option>
    </select>
  );
};

export default Dropdown;
