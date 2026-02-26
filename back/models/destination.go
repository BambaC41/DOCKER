package models

type Destination struct {
    ID          int    `json:"id"`
    Name        string `json:"name"`
    Country     string `json:"country"`     
    Description string `json:"description"`
    Image       string `json:"image_url"`   

}
