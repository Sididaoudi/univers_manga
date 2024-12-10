import React, { useState, useEffect } from 'react';

const Selection = ({ applyFilters, selectedGenre }) => {
  const [genre, setGenre] = useState(selectedGenre || '');
  const [genres, setGenres] = useState([]); // État pour les genres récupérés de l'API

  // Récupérer les genres via un fetch
  useEffect(() => {
    fetch('http://localhost:8000/api/genre') // Récupérer toutes les données des mangas
      .then((response) => response.json())
      .then((data) => {
        if (data && data.mangas) {
          // Extraire les genres uniques à partir des mangas récupérés
          const uniqueGenres = new Set();
          data.mangas.forEach((manga) => {
            manga.genre.split(', ').forEach((genre) => {
              uniqueGenres.add(genre.trim());
            });
          });
          setGenres(Array.from(uniqueGenres)); // Mettre à jour les genres
        }
      })
      .catch((error) => {
        console.error('Erreur lors de la récupération des mangas', error);
      });
  }, []); // Le fetch se déclenche une seule fois au montage du composant

  // Lorsque le genre change, on applique les filtres
  const handleGenreChange = (event) => {
    const selectedGenre = event.target.value;
    setGenre(selectedGenre);
    applyFilters(selectedGenre); // Applique le filtre de genre dans le parent
  };

  useEffect(() => {
    if (selectedGenre) {
      setGenre(selectedGenre); // Mettre à jour le genre sélectionné dans le composant
    }
  }, [selectedGenre]); // Si le genre sélectionné change dans le parent, mettez à jour l'état local

  return (
    <div className='choice'>
      <form className="max-w-sm mx-auto">
        <div>
          <label htmlFor="genre_select" className="sr-only">Sélectionner un genre</label>
          <select
            id="genre_select"
            className="selection"
            onChange={handleGenreChange}
            value={genre}
          >
            <option value="" disabled>Genre</option>
            {/* Afficher les genres récupérés */}
            {genres.map((genre, index) => (
              <option key={index} value={genre}>{genre}</option>
            ))}
          </select>
        </div>
      </form>
    </div>
  );
};

export default Selection;
