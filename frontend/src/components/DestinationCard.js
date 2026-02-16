import React from "react";
import { Link } from "react-router-dom";

function DestinationCard({ destination }) {
  if (!destination) return null;
  const { id, name, country, image_url, description } = destination;

  return (
    <article className="card">
      <Link to={`/destination/${id}`} className="card-link">
        <div className="card-img-wrap">
          <img src={image_url} alt={name} className="card-img" />
        </div>
        <div className="card-body">
          <h3 className="card-title">{name}</h3>
          <div className="muted">{country}</div>
          <p className="card-desc">
            {description ? (description.length > 120 ? description.slice(0, 120) + "…" : description) : ""}
          </p>
        </div>
      </Link>
    </article>
  );
}

export default DestinationCard;