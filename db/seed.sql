CREATE TABLE IF NOT EXISTS destinations (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  country VARCHAR(100) NOT NULL,
  description TEXT,
  image_url TEXT
);

CREATE TABLE IF NOT EXISTS favorites (
  id INT AUTO_INCREMENT PRIMARY KEY,
  destination_id INT NOT NULL,
  added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (destination_id) REFERENCES destinations(id) ON DELETE CASCADE
);

INSERT INTO destinations (name, country, description, image_url) VALUES
('Paris', 'France', 'Ville lumiere connue pour la Tour Eiffel.', 'https://marketplace.canva.com/MADar1MzO1U/1/thumbnail_large-1/canva-eiffel-tower%2C-paris-MADar1MzO1U.jpg'),
('Tokyo', 'Japon', 'Ville moderne melee de traditions et technologie.', 'https://media.istockphoto.com/id/1390815938/fr/photo/ville-de-tokyo-au-japon.jpg?s=612x612&w=0&k=20&c=nF3NZRxqZ08TggdR4svQ718LhlrMBjtQjkHfEQf4xZw='),
('New York', 'Etats-Unis', 'Metropole dynamique connue pour Times Square.', 'https://media.istockphoto.com/id/1454217037/fr/photo/statue-de-la-libert%C3%A9-et-new-york-city-skyline-avec-manhattan-financial-district-world-trade.jpg?s=612x612&w=0&k=20&c=Bh0_fEkRd8qbhUDopYrEZfU-nsKy4B36x0o7Z6R7P14=');

INSERT INTO favorites (destination_id) VALUES (1), (2);
