package models

type Favorite struct {
    ID            int    `json:"id"`
    DestinationID int    `json:"destination_id"`
    CreatedAt     string `json:"added_at"`
}