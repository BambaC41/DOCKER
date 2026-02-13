import { BrowserRouter as Router, Routes, Route, Link } from "react-router-dom";
import Home from "./pages/Home";
import Detail from "./pages/Detail";
import Favorites from "./pages/Favorites";

function App() {
  return (
    <Router>
      <nav style={{ padding: "20px", background: "#111" }}>
        <Link to="/" style={{ marginRight: "20px", color: "white" }}>
          Home
        </Link>
        <Link to="/favorites" style={{ color: "white" }}>
          Favoris
        </Link>
      </nav>

      <Routes>
        <Route path="/" element={<Home />} />
        <Route path="/destination/:id" element={<Detail />} />
        <Route path="/favorites" element={<Favorites />} />
      </Routes>
    </Router>
  );
}

export default App;