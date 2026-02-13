import { Link } from "react-router-dom";

function DestinationCard({ destination }) {
  return (
    <div style={{ width: "250px", background: "#222", color: "white", padding: "10px", borderRadius: "10px" }}>
      <img
        src={destination.image_url}
        alt={destination.name}
        style={{ width: "100%", borderRadius: "10px" }}
      />
      <h3>{destination.name}</h3>
      <p>{destination.country}</p>
      <Link to={`/destination/${destination.id}`} style={{ color: "cyan" }}>
        Voir détail
      </Link>
    </div>
  );
}

export default DestinationCard;