package main

import (
	"fmt"
	"log"
	"net/http"
	"os"

	"github.com/Api_voyage/app"
	"github.com/Api_voyage/db"
)

func main() {
	if os.Getenv("DB_HOST") != "" || os.Getenv("DB_USER") != "" {
		db.Conn = db.NewDB()
	}

	http.HandleFunc("GET /health", app.HealthCheck)
	http.HandleFunc("GET /ping", app.PingCheck)

	http.HandleFunc("GET /destinations", app.GetAllDestinations)
	http.HandleFunc("GET /destinations/{id}", app.GetDestinationByID)

	http.HandleFunc("GET /favorites", app.GetAllFavorites)
	http.HandleFunc("POST /favorites", app.CreateFavorite)
	http.HandleFunc("DELETE /favorites/{id}", app.DeleteFavorite)

	fmt.Println("Listening at http://localhost:8080")
	log.Fatal(http.ListenAndServe(":8080", nil))
}

