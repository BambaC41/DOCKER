package app

import (
	"encoding/json"
	"fmt"
	"net/http"
	"strconv"

	"github.com/Api_voyage/db"
)

func GetAllDestinations(w http.ResponseWriter, r *http.Request) {
	destinations, err := db.GetAllDestinations()
	if err != nil {
		fmt.Println("GetAllDestinations error:", err)
		http.Error(w, "internal error", http.StatusInternalServerError)
		return
	}
	w.Header().Set("Content-Type", "application/json")
	json.NewEncoder(w).Encode(destinations)
}


func GetDestinationByID(w http.ResponseWriter, r *http.Request) {
	idStr := r.PathValue("id")
	if idStr == "" {
		idStr = r.URL.Query().Get("id")
	}
	id, err := strconv.Atoi(idStr)
	if err != nil {
		http.Error(w, "bad id", http.StatusBadRequest)
		return
	}

	d, err := db.GetDestinationByID(id)
	if err != nil {
		fmt.Println("GetDestinationByID error:", err)
		http.Error(w, "internal error", http.StatusInternalServerError)
		return
	}

	if d == nil {
		http.Error(w, "not found", http.StatusNotFound)
		return
	}
	w.Header().Set("Content-Type", "application/json")
	_ = json.NewEncoder(w).Encode(d)
}