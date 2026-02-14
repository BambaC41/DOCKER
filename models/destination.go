package models

type Destination struct {
    ID          int    `json:"id"`
    Name        string `json:"name"`
    Country     string `json:"country"`     // Ajouté pour correspondre à ta BDD
    Description string `json:"description"`
    Image       string `json:"image_url"`   // Correspond à image_url en BDD
}