import React, { useEffect, useState } from 'react';
import Navbar from '../../component/Navbar/Nav';

function Home() {
    const [mangas, setMangas] = useState([]); // L'état pour stocker les mangas

    useEffect(() => {
        // Appel API pour récupérer les mangas
        fetch('http://localhost:8000/')
            .then((response) => response.json())
            .then((data) => {
                // On affecte les mangas récupérés à l'état
                setMangas(data.mangas);
            })
            .catch((error) => console.error('Erreur lors de la récupération des données'));
    }, []); // Le tableau vide indique que le hook se lance seulement au montage du composant

    return (
        <div id="main-page">
            <Navbar/>
            <section className='planning-of-the-week'>
                <h2>Nouveautés</h2>
                <div className='planning-content'>
                    {mangas.map((manga) => (
                        <div key={manga.id} className='cards'>
                            <img src={manga.thumbnail} alt={manga.title} />
                            <h3>{manga.title}</h3>
                            <p>{new Date(manga.releaseDate).toLocaleDateString()}</p>
                        </div>
                    ))}
                </div>
            </section>
        </div>
    );
}

export default Home;
