import React from "react";
import { useParams } from "react-router-dom";

function DestinationDetail() {
  const { id } = useParams();

  return (
    <div>
      <h2>Détail destination {id}</h2>
    </div>
  );
}

export default DestinationDetail;