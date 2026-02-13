import { useEffect, useState } from "react";
import { getDestinations } from "../services/api";
import DestinationCard from "../components/DestinationCard";

function Home() {
  const [destinations, setDestinations] = useState([]);

  useEffect(() => {
    getDestinations().then(setDestinations);
  }, []);

  return (
    <div>
      <h1>City Guide 🌍</h1>
      <div style={{ display: "flex", flexWrap: "wrap", gap: "20px" }}>
        {destinations.map((d) => (
          <DestinationCard key={d.id} destination={d} />
        ))}
      </div>
    </div>
  );
}

export default Home;