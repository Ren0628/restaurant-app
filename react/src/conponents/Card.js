import { Link } from "react-router-dom";

function Card({restaurant}) {
  return (
    <div className="col d-flex justify-content-center">
      <div className="card restaurant-card">
        <Link to={`/show/${restaurant.id}`} className="text-decoration-none">
          <img src={`http://localhost/laravel-restaurant-app/public/storage/${restaurant.img_path}`} className="card-img-top" alt="..." />
          <div className="card-body">
              <p className="card-text">{restaurant.genre}</p>
              <h5 className="card-title">{restaurant.restaurant_name}</h5>
              <p className="card-text">{restaurant.access}</p>
          </div>
        </Link>
      </div>
    </div>
  )
}

export default Card;