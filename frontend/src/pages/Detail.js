import React, { useEffect, useState } from "react";
import { useParams } from "react-router-dom";
import { getDestination } from "../services/api";

function Detail() {
  const { id } = useParams();
  const [destination, setDestination] = useState(null);

  useEffect(() => {
    getDestination(id).then(setDestination);
  }, [id]);

  if (!destination) return <div style={{ padding: 20 }}>Chargement...</div>;

  return (
    <div className="detail-wrap">
      <h1 style={{ margin: 0 }}>{destination.name}</h1>
      <h3 style={{ color: "#666", marginTop: 6 }}>{destination.country}</h3>
      <div style={{ maxWidth: 800 }}>
        <img
          src={destination.image_url}
          alt={destination.name}
          className="detail-image"
        />
        <p style={{ marginTop: 12 }}>{destination.description}</p>
      </div>
    </div>
  );
}

export default Detail;