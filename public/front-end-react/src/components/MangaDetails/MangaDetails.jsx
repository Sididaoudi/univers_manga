import React, { useEffect, useState } from "react";
import { useParams } from "react-router-dom";

const MangaDetails = ({ thumbnail }) => {
  const [manga, setManga] = useState({});
  const [mangaka, setMangaka] = useState({});
  const [genres, setGenres] = useState([]);
  const [type, setType] = useState(null);
  const { id } = useParams();

  const imageUrl = `http://localhost:8000${thumbnail}`;

  useEffect(() => {
    fetch(`http://localhost:8000/api/manga/${id}`)
      .then((response) => response.json())
      .then((data) => {
        if (data && data.manga) {
          setManga(data.manga);
        } else {
          console.log("La structure des données est incorrecte", data);
        }
      })
      .catch((error) =>
        console.log("Erreur lors de la récupération des données", error)
      );
  }, []);

  useEffect(() => {
    fetch(`http://localhost:8000/api/mangaka/${id}`)
      .then((response) => response.json())
      .then((data) => {
        if (data && data.mangaka) {
          setMangaka(data.mangaka);
        } else {
          console.log("La structure des données est incorrecte", data);
        }
      })
      .catch((error) =>
        console.log("Erreur lors de la récupération des données", error)
      );
  }, []);

  useEffect(() => {
    fetch(`http://localhost:8000/api/genres`)
      .then((response) => response.json())
      .then((data) => {
        if (data && data.genres) {
          setGenres(data.genres);
        } else {
          console.log("La structure des données est incorrecte", data);
        }
      })
      .catch((error) =>
        console.log("Erreur lors de la récupération des données", error)
      );
  }, []);

  useEffect(() => {
    fetch(`http://localhost:8000/api/type/${id}`)
      .then((response) => response.json())
      .then((data) => {
        console.log("Données reçues:", data);
        if (data && data.type) {
          setType(data.type);
        } else {
          console.log("La structure des données est incorrecte", data);
        }
      })
      .catch((error) =>
        console.log("Erreur lors de la récupération des données", error)
      );
  }, []);

  return (
    <div className="single-product-page">
      <h2 className="single-product-title">{manga.title}</h2>

      <div className="single-product-content">
        <div className="single-product-left">
          <div className="product-img">
            <img src={`http://localhost:8000/images/manga/${manga.thumbnail}`} />
          </div>
          

          {/* <div className="buttons">
            <div className="buy-btn">
              <button>Acheter</button>
            </div>
          </div> */}
        </div>

        <div className="single-product-right">
          <div className="product-info-details">
            <section className="product-info-left">
              <ul>
                <li>Titre original</li>
                <li>Auteur</li>
                <li>Genres</li>
                <li>Type</li>
                <li>Nombres de pages</li>
                <li>Date de sortie</li>
              </ul>
            </section>

            <section className="product-info-right">
              <ul>
                <li>{manga.originalName || "Non spécifié"}</li>
                <li>{mangaka.name}</li>
                <li>
                  {manga.genre?.map((genre, index) => (
                    <span key={index}>
                      {genre.name}
                      {index < manga.genre.length - 1 ? ", " : ""}
                    </span>
                  ))}
                </li>
                <li>{manga.typeManga?.name || "Type non disponible"}</li>
                <li>{manga.numberPages}</li>
                <li>{new Date(manga.release_date).toLocaleDateString()}</li>
                <li></li>
              </ul>
            </section>
          </div>
        </div>
      </div>
       <section className="single-product-down">
          <article className="product-resume">
          <p>Résumé : </p>
          <p>{manga.synopsis }</p>
          </article>
       </section>
    </div>
  );
};

export default MangaDetails;
