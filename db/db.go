package db

import (
	"database/sql"
	"fmt"
	"log"
	"os"
	"strconv"

	_ "github.com/go-sql-driver/mysql"
)

const driver = "mysql"

var Conn *sql.DB

func envOrDefault(key, def string) string {
	if v := os.Getenv(key); v != "" {
		return v
	}
	return def
}

func NewDB() *sql.DB {
	// 1. Lecture des variables d'environnement
	user := envOrDefault("DB_USER", "root")
	password := envOrDefault("DB_PASSWORD", "root")
	host := envOrDefault("DB_HOST", "localhost")
	dbname := envOrDefault("DB_NAME", "voyage_db")

	port := 3306
	if p := os.Getenv("DB_PORT"); p != "" {
		if n, err := strconv.Atoi(p); err == nil {
			port = n
		}
	}

	// 2. Construction du DSN (Data Source Name)
	dsn := fmt.Sprintf("%s:%s@tcp(%s:%d)/%s", user, password, host, port, dbname)
	
	// 3. Tentative de connexion
	db, err := sql.Open(driver, dsn)
	if err != nil {
		log.Printf("❌ Erreur de configuration DB: %v", err)
		return nil
	}

	// 4. Verification de la connexion (Ping)
	// On ne fait pas de panic ici pour permettre le mode "CSV local" si la DB est absente
	if err := db.Ping(); err != nil {
		log.Printf("⚠️  Impossible de joindre MySQL sur %s:%d. L'API fonctionnera en mode CSV local.", host, port)
		return nil 
	}

	fmt.Printf("✅ Connecté avec succès à la base de données '%s' sur %s:%d\n", dbname, host, port)
	Conn = db
	return db
}