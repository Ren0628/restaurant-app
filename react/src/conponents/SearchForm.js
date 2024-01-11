import { Link } from "react-router-dom";
import KeywordForm from "./KeywordForm";
import { useState } from "react"
import SearchNearby from "./SearchNearby";
import axios from "axios";

function SearchForm({genres, setRestaurants}) {

  const [keyword, setKeyword] = useState('');
  const [genre, setGenre] = useState('');
  const [currentLocation, setCurrentLocation] = useState('');

  const handleClick = () => {
    setKeyword('');
    setGenre('');
    setCurrentLocation('');

    axios
      .get(`/api/restaurants`)
      .then((res) => {
        setRestaurants(res.data.restaurants);
      });
  }

  return (
    <div className="d-flex flex-wrap">
      <KeywordForm genres={genres} setRestaurants={setRestaurants} keyword={keyword} setKeyword={setKeyword} genre={genre} setGenre={setGenre} />
      <SearchNearby setRestaurants={setRestaurants} currentLocation={currentLocation} setCurrentLocation={setCurrentLocation} />
      <button onClick={handleClick} className="btn btn-outline-danger mb-3 ms-2">リセット</button>
    </div>
  )
}

export default SearchForm;