import axios from "axios";


function SearchNearby({setRestaurants, currentLocation, setCurrentLocation}) {

  const handleSubmit = (e) => {
    e.preventDefault();

    const file = new FormData()

    file.append("currentLocation", currentLocation);

    axios
      .post(`/api/restaurants/nearby`, file)
      .then((res) => {
        setRestaurants(res.data.restaurants);
      });

  }

  return (
    <form onSubmit={handleSubmit}>
      <div className="input-group mb-3">
        <input type="text" className="form-control" placeholder="現在地を入力" name="currentLocation" value={currentLocation} onChange={(e) => {setCurrentLocation(e.target.value)}} />
        <button className="btn btn-outline-success" type="submit"><i className="fas fa-search"></i> 近くのお店を検索</button>
      </div>
    </form>
  )
}

export default SearchNearby