import React, { useEffect, useState } from "react";
import { useLocation } from "react-router-dom";
import { format } from 'date-fns';
import { fr } from 'date-fns/locale';
import { Link } from "react-router-dom";

function Results() {
  const location = useLocation();
  const queryParams = new URLSearchParams(location.search);
  const term = queryParams.get("term");
  const [results, setResults] = useState([]); // On garde uniquement results ici
  
  useEffect(() => {
    if (term) {
      fetch(`http://localhost:8000/api/search?term=${term}`)
        .then((response) => response.json())
        .then((data) => {
          console.log("Données récupérées:", JSON.stringify(data, null, 2)); // Affichage de la structure des données
          setResults(data.results || []); // On se concentre uniquement sur 'results'
        })
        .catch((error) => console.error("Erreur lors de la récupération des résultats:", error));
    }
  }, [term]);

  return (
    <div className="product">
      <div className="result-content">
        <div className="cards">
          {results.length > 0 ? (
            results.map((manga) => {
              const imageUrl = `http://localhost:8000/images/manga/${manga.thumbnail}`;  // Construire l'URL de l'image
              
              // Parse et formatage de la date
              const releaseDateParsed = manga.release_date ? new Date(manga.release_date) : null;
              const isValidDate = releaseDateParsed && !isNaN(releaseDateParsed.getTime());
              const formattedDate = isValidDate 
                ? format(releaseDateParsed, 'dd/MM/yyyy', { locale: fr }) 
                : "Date non disponible";

              return (
                <div key={manga.id}>
                   <div key={manga.id}>
                  <Link to={`/manga/${manga.id}`}> {/* Ajouter le lien ici */}
                    <div className="card">
                      <img src={imageUrl} alt={manga.title} />
                      <h3>{manga.title}</h3>
                      <div className="card-date">Date de sortie : {formattedDate}</div>
                    </div>
                  </Link>
                </div>
                </div>
              );
            })
          ) : (
            <p>Aucun résultat trouvé pour "{term}".</p> // Affichage d'un message si aucun résultat
          )}
        </div>
      </div>
    </div>
  );
}

export default Results;
