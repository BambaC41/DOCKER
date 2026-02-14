-- Création de la table destinations
CREATE TABLE IF NOT EXISTS destinations (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  country VARCHAR(100) NOT NULL,
  description TEXT,
  image_url TEXT
);

-- Insertion de quelques destinations
INSERT INTO destinations (name, country, description, image_url) VALUES
('Paris', 'France', 'Ville lumière connue pour la Tour Eiffel.', 'https://example.com/paris.jpg'),
('Tokyo', 'Japon', 'Ville moderne mêlée de traditions et technologie.', 'https://example.com/tokyo.jpg'),
('New York', 'États-Unis', 'Métropole dynamique connue pour Times Square.', 'https://example.com/nyc.jpg');
