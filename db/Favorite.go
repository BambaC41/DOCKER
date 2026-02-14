package db

import (
	"fmt"
	"github.com/Api_voyage/models"
)


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
