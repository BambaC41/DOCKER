package db

import (
	"database/sql"
	"fmt"

	"github.com/Api_voyage/models"
)

func GetAllDestinations() ([]models.Destination, error) {
	if Conn == nil {
		return nil, fmt.Errorf("la connexion à la base de données est inexistante")
	}

	rows, err := Conn.Query("SELECT id, name, description, image_url, country FROM destinations")
	if err != nil {
		return nil, fmt.Errorf("erreur lors de la récupération des destinations: %w", err)
	}
	defer rows.Close()

	var out []models.Destination
	for rows.Next() {
		var d models.Destination
		if err := rows.Scan(&d.ID, &d.Name, &d.Description, &d.Image, &d.Country); err != nil {
			return nil, err
		}
		out = append(out, d)
	}
	return out, rows.Err()
}

func GetDestinationByID(id int) (*models.Destination, error) {
	if Conn == nil {
		return nil, fmt.Errorf("la connexion à la base de données est inexistante")
	}

	var d models.Destination
	err := Conn.QueryRow("SELECT id, name, description, image_url, country FROM destinations WHERE id = ?", id).
		Scan(&d.ID, &d.Name, &d.Description, &d.Image, &d.Country)
	
	if err == sql.ErrNoRows {
		return nil, nil
	}
	if err != nil {
		return nil, err
	}
	return &d, nil
}