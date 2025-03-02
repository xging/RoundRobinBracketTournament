// app/page.jsx
// import "bootstrap/dist/css/bootstrap.min.css";
import React from "react";

// import "./styles.css";
import "../styles/grid.css";
import TournamentGrid from "../components/round-robin-grid/TournamentGrid";

export default function Home() {
  return (
    <div>
      <TournamentGrid />
    </div>
  );
}
