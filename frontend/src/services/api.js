// ⚠ MOCK TEMPORAIRE (en attendant le backend)

const mockDestinations = [
  {
    id: 1,
    name: "Paris",
    country: "France",
    image_url: "https://images.unsplash.com/photo-1502602898657-3e91760cbb34",
    description: "La ville lumière et la Tour Eiffel."
  },
  {
    id: 2,
    name: "Tokyo",
    country: "Japon",
    image_url: "https://images.unsplash.com/photo-1549692520-acc6669e2f0c",
    description: "La capitale futuriste du Japon."
  },
  {
    id: 3,
    name: "Rome",
    country: "Italie",
    image_url: "https://images.unsplash.com/photo-1529156069898-49953e39b3ac",
    description: "La ville éternelle et le Colisée."
  }
];

export const getDestinations = async () => {
  return mockDestinations;
};

export const getDestination = async (id) => {
  return mockDestinations.find(d => d.id === parseInt(id));
};

let favorites = [];

export const getFavorites = async () => {
  return favorites;
};

export const addFavorite = async (destinationId) => {
  favorites.push({ id: Date.now(), destination_id: destinationId });
};

export const removeFavorite = async (destinationId) => {
  favorites = favorites.filter(f => f.destination_id !== destinationId);
};