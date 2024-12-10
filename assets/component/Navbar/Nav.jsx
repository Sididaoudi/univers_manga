import React, { useState } from "react";
// import { GiHamburgerMenu } from "react-icons/gi";
// import Search from "../Search/Search";
import { Link } from "react-router-dom";
// import logo from "../../assets/logo/Univers-manga-logo.webp";
// import "./Navbar.css";

const Navbar = () => {
  const [toggleMenu, setToggleMenu] = useState(false);

  return (
    <nav className="nav">
      <ul className="nav-links">
        <li className="dropdown">
          <Link to="/manga-overview">Mangas</Link>
          <ul className="submenu">
            <li><Link to="/AllManga">Tous les mangas</Link></li>
            <li><Link to="/CultManga">Planning des sorties</Link></li>
            <li><Link to="/Review">Genres</Link></li>
          </ul>
        </li>

      </ul>


      <Search />
      <div className="navbar-smallscreen">
        <GiHamburgerMenu
          color="#fff"
          fontSize={30}
          onClick={() => setToggleMenu(!toggleMenu)}
        />
        {toggleMenu && (
          <div className="navbar-smallscreen_overlay">
            <GiHamburgerMenu
              color="#fff"
              fontSize={27}
              className="overlay__close"
              onClick={() => setToggleMenu(false)}
            />
            <ul className="navbar-smallscreen_links">
              <li><Link to="/">Accueil</Link></li>
              <li><Link to="/AllManga">Tous les mangas</Link></li>
              <li><Link to="/CultManga">Planning des sorties</Link></li>
              <li><Link to="/Review">Critiques</Link></li>
            </ul>
          </div>
        )}
      </div>
    </nav>
  );
};

export default Navbar;
