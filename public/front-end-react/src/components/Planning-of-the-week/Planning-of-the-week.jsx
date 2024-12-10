import React, { useEffect, useState } from "react";
import MangaCard from "../MangaCard/MangaCard";
import { Link } from "react-router-dom";

const PlanningOfTheWeek = () => {
  const [mangas, setMangas] = useState([]);

  useEffect(() => {
    fetch("http://localhost:8000/api/mangas")
      .then((response) => response.json())
      .then((data) => {
        console.log("Données reçues:", data);
        if (data && data.mangas) {
          setMangas(data.mangas);
        } else {
          console.log("La structure des données est incorrecte", data);
        }
      })
      .catch((error) =>
        console.log("Erreur lors de la récupération des données", error)
      );
  }, []);

  return (
    <section className="planning-of-the-week">
      <h2>Sorties de la semaine</h2>

      <div className="planning-content">
        <div className="cards">
          {mangas.length > 0 ? (
            mangas.map((manga) => (
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
            ))
          ) : (
            <div></div>
          )}
        </div>
      </div>
      <div className="more-Btn">
          <button>
            <Link to="/Release" >Planning des sorties</Link>
          </button>
      </div>
    </section>
  );
};

export default PlanningOfTheWeek;
