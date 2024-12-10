import React from 'react';
import "../../index.css";
import { format } from 'date-fns';
import { fr } from 'date-fns/locale';


const MangaCard = ({ title, thumbnail, id, releaseDate }) => {

  
  const imageUrl = `http://localhost:8000${thumbnail}`;
  
  
  const releaseDateParsed = releaseDate ? new Date(releaseDate) : null;
  const isValidDate = releaseDateParsed && !isNaN(releaseDateParsed.getTime());

  if (!id || !title || !thumbnail) {
    return <div className="manga-card">Données manquantes</div>;
  }

  return (
    <div className="card">
      <img src={imageUrl} alt={title} />
      <h3 className='card-title'>{title}</h3>
       <div className="card-date">
       {" "}
        {isValidDate
          ? format(releaseDateParsed, 'dd/MM/yyyy', { locale: fr })
          : "Date non disponible"}
      </div>
    </div>
  );
};

export default MangaCard;
