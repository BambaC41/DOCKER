# Api Voyage

API Go : destinations et favoris.

## Lancer

```powershell
go run api.go
```

→ **http://localhost:8080**

Sans `DB_HOST`/`DB_USER` : CSV dans `data/`. Avec variables DB : MySQL (table `favorites`).

## Variables d'environnement (MySQL / Docker)

| Variable      | Défaut    |
| ------------- | --------- |
| `DB_USER`     | root      |
| `DB_PASSWORD` | root      |
| `DB_HOST`     | localhost |
| `DB_PORT`     | 3306      |
| `DB_NAME`     | _(vide)_  |

## Endpoints

| Méthode | URL                                                    |
| ------- | ------------------------------------------------------ |
| GET     | `/health`, `/ping`                                     |
| GET     | `/destinations`, `/destinations/{id}`                  |
| GET     | `/favorites` (?user_id=1)                              |
| POST    | `/favorites` — body `{"user_id":1,"destination_id":3}` |
| DELETE  | `/favorites/{id}`                                      |

## CSV (sans BDD)

- `data/destinations.csv` — `id,name,description,image,price`
- `data/favorites.csv` — `id,user_id,destination_id,created_at`

Option : `API_VOYAGE_DATA_DIR` pour changer le dossier (défaut : `data`).

