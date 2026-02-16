import React, { useEffect, useState } from "react";
import { getFavorites, getDestination } from "../services/api";
import DestinationCard from "../components/DestinationCard";

function Favorites() {
  const [items, setItems] = useState([]);

  useEffect(() => {
    async function load() {
      const favs = await getFavorites();
      const results = [];
      for (const f of favs) {
        const d = await getDestination(f.destination_id);
        if (d) results.push(d);
      }
      setItems(results);
    }
    load();
  }, []);

  if (!items.length) return <div className="empty">Aucun favori pour le moment.</div>;

  return (
    <div style={{ padding: 20 }}>
      <h1>Favoris</h1>
      <div className="grid">
        {items.map(d => <DestinationCard key={d.id} destination={d} />)}
      </div>
    </div>
  );
}

export default Favorites;