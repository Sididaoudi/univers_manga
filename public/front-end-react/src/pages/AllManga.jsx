import React, { useState, useEffect } from "react";
import MangaCard from "../components/MangaCard/MangaCard";
import { Link } from "react-router-dom";

function AllManga() {
  const [mangas, setMangas] = useState([]); // État pour les mangas

  // Charger les mangas au démarrage
  useEffect(() => {
    fetch("http://localhost:8000/api/allmanga")
      .then((response) => {
        console.log("Réponse API:", response); // Vérifier la réponse du serveur
        return response.json();  // Essayer de convertir la réponse en JSON
      })
      .then((data) => {
        console.log("Données récupérées:", data); // Vérifier les données récupérées
        setMangas(data.mangas || []); // Mettre à jour les mangas
      })
      .catch((error) => {
        console.log("Erreur lors de la récupération des mangas:", error);
      });
  }, []); // Ce useEffect s'exécute une seule fois au montage du composant

  return (
    <div className="product">
      <div className="product-content">
        {mangas.length > 0 ? (
          mangas.map((manga) => {
            return (
              <div key={manga.id}>
                <Link to={`/manga/${manga.id}`}>
                <MangaCard
                  thumbnail={manga.thumbnail}
                  id={manga.id}
                  title={manga.title}
                  releaseDate={manga.release_date}
                />
                </Link>
              </div>
            );
          })
        ) : (
          <div>Aucun manga trouvé.</div> // Message si aucun manga n'est trouvé
        )}
      </div>
    </div>
  );
}

export default AllManga;
