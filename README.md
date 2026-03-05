# Api Voyage

API Go : destinations et favoris.

## Lancer

### back :
docker run -d -p 8080:8080 --name api-voyage-prod --network project_app-network -e DB_HOST=172.18.0.2   -e DB_USER=appuser   -e DB_PASSWORD=motdepasseApp   -e DB_NAME=voyages   adixdix/back-api-voyage:v1.11
### front :
docker run -d --name cityguide-front \
  -p 8000:80 \
  -e API_BASE="http://<IP_DE_SON_API>:8080" \
  bambac41/cityguide-front:latest

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



