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
      <div style={{ display: "flex", justifyContent: "space-between", alignItems: "center", marginBottom: 6 }}>
        <h1 className="page-title">City Guide <span className="page-sub">Découvre des villes inspirantes</span></h1>
      </div>

      <div className="grid">
        {destinations.map((d) => (
          <DestinationCard key={d.id} destination={d} />
        ))}
      </div>
    </div>
  );
}

export default Home;