package db

import (
	"fmt"
	"github.com/Api_voyage/models"
)

// GetAllFavorites récupère tous les favoris (le filtrage par UserID est retiré car absent de la table)
func GetAllFavorites() ([]models.Favorite, error) {
	if Conn == nil {
		return nil, fmt.Errorf("connexion DB inactive")
	}

	rows, err := Conn.Query("SELECT id, destination_id, added_at FROM favorites")
	if err != nil {
		return nil, err
	}
	defer rows.Close()

	var favs []models.Favorite
	for rows.Next() {
		var f models.Favorite
		// On scanne uniquement les colonnes existantes dans ta nouvelle table
		if err := rows.Scan(&f.ID, &f.DestinationID, &f.CreatedAt); err != nil {
			return nil, err
		}
		favs = append(favs, f)
	}
	return favs, rows.Err()
}

func CreateFavorite(destinationID int) (models.Favorite, error) {
	if Conn == nil {
		return models.Favorite{}, fmt.Errorf("connexion DB inactive")
	}

	// MySQL gère le added_at automatiquement (DEFAULT CURRENT_TIMESTAMP)
	res, err := Conn.Exec("INSERT INTO favorites (destination_id) VALUES (?)", destinationID)
	if err != nil {
		return models.Favorite{}, err
	}

	id, err := res.LastInsertId()
	if err != nil {
		return models.Favorite{}, err
	}

	return models.Favorite{
		ID:            int(id),
		DestinationID: destinationID,
		// Note : CreatedAt sera vide ici à moins de faire un SELECT, 
		// ou tu peux mettre l'heure actuelle en Go.
	}, nil
}

func DeleteFavoriteByID(id int) (bool, error) {
	if Conn == nil {
		return false, fmt.Errorf("connexion DB inactive")
	}

	res, err := Conn.Exec("DELETE FROM favorites WHERE id = ?", id)
	if err != nil {
		return false, err
	}

	aff, err := res.RowsAffected()
	if err != nil {
		return false, err
	}
	return aff > 0, nil
}