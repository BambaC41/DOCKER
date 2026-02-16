import { BrowserRouter as Router, Routes, Route, Link } from "react-router-dom";
import Home from "./pages/Home";
import Detail from "./pages/Detail";
import Favorites from "./pages/Favorites";

function App() {
  return (
    <Router>
      <header className="site-header">
        <div className="container">
          <div className="brand">
            <span className="logo" aria-hidden />
            City Guide
          </div>
          <nav className="nav">
            <Link to="/" className="nav-link">Home</Link>
            <Link to="/favorites" className="nav-link">Favoris</Link>
          </nav>
        </div>
      </header>

      <main className="container content">
        <Routes>
          <Route path="/" element={<Home />} />
          <Route path="/destination/:id" element={<Detail />} />
          <Route path="/favorites" element={<Favorites />} />
        </Routes>
      </main>
    </Router>
  );
}

export default App;