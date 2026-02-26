package app

import (
	"encoding/json"
	"fmt"
	"net/http"
	"strconv"

	"github.com/Api_voyage/db"
)

func GetAllFavorites(w http.ResponseWriter, r *http.Request) {
	favs, err := db.GetAllFavorites() 
	if err != nil {
		fmt.Println("GetAllFavorites error:", err)
		http.Error(w, "internal error", http.StatusInternalServerError)
		return
	}

	w.Header().Set("Content-Type", "application/json")
	_ = json.NewEncoder(w).Encode(favs)
}

type createFavoriteRequest struct {
	DestinationID int `json:"destination_id"`
}

func CreateFavorite(w http.ResponseWriter, r *http.Request) {
	var req createFavoriteRequest
	if err := json.NewDecoder(r.Body).Decode(&req); err != nil {
		http.Error(w, "bad json", http.StatusBadRequest)
		return
	}

	if req.DestinationID <= 0 {
		http.Error(w, "destination_id required", http.StatusBadRequest)
		return
	}

	fav, err := db.CreateFavorite(req.DestinationID)
	if err != nil {
		fmt.Println("CreateFavorite error:", err)
		http.Error(w, "internal error", http.StatusInternalServerError)
		return
	}

	w.Header().Set("Content-Type", "application/json")
	w.WriteHeader(http.StatusCreated)
	_ = json.NewEncoder(w).Encode(fav)
}

func DeleteFavorite(w http.ResponseWriter, r *http.Request) {
	idStr := r.PathValue("id")
	if idStr == "" {
		idStr = r.URL.Query().Get("id")
	}
	id, err := strconv.Atoi(idStr)
	if err != nil {
		http.Error(w, "bad id", http.StatusBadRequest)
		return
	}

	ok, err := db.DeleteFavoriteByID(id)
	if err != nil {
		fmt.Println("DeleteFavorite error:", err)
		http.Error(w, "internal error", http.StatusInternalServerError)
		return
	}
	if !ok {
		http.Error(w, "not found", http.StatusNotFound)
		return
	}

	w.WriteHeader(http.StatusNoContent)

}
