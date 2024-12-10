import React from "react";
import { BrowserRouter as Router, Route, Routes } from "react-router-dom";
import Home from "./pages/Home"; 
import AllManga from "./pages/AllManga";
import MangaDetails from "./components/MangaDetails/MangaDetails";
import Release from "./pages/Release";
import Navbar from "./components/Navbar/Nav";
import Search from "./components/Search/Search";
import Results from "./components/Search/Results";
import Footer from "./components/Footer/Footer";
import "./index.css"; 


function App() {
  return (
    <Router>
      <div>
        <Navbar />
        <Routes>
          <Route path="/" element={<Home />} />
          <Route path="/" element={<Search />} />
          <Route path="/results" element={<Results />} />
          <Route path="/AllManga" element={<AllManga />} />
          <Route path="/Release" element={<Release />} />
          <Route path="/manga/:id" element={<MangaDetails />} />
        </Routes>
        <Footer />
      </div>
    </Router>
  );
}

export default App;
