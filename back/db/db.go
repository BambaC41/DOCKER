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

	dsn := fmt.Sprintf("%s:%s@tcp(%s:%d)/%s", user, password, host, port, dbname)
	
	db, err := sql.Open(driver, dsn)
	if err != nil {
		return nil
	}

	if err := db.Ping(); err != nil {
		return nil 
	}

	Conn = db
	return db

}
