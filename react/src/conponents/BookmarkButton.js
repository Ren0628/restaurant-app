import axios from 'axios';
import { useEffect, useState } from 'react';

function BookmarkButton({restaurant, setMessage, setRestaurants}) {

  const [bookmark, setBookmark] = useState();

  useEffect(() => {
      try{
        axios.post(`/api/isBookmark/${restaurant.id}`)
        .then((res) => {
          setBookmark(res.data.isBookmark);
        });
      } catch(e) {
        return e;
      }
  }, []);

  const handleClick = () => {
    axios
    .post(`/api/bookmark/${restaurant.id}`)
    .then((res) => {
      setBookmark(res.data.isBookmark);
      setRestaurants(res.data.restaurants);
      setMessage(res.data.message);
    })
  }

  let button;

  if(bookmark === true) {
    button = <button className="btn btn-secondary" onClick={handleClick}>お気に入り解除</button>;
  } else if(bookmark === false) {
    button =<button className="btn btn-success" onClick={handleClick}>お気に入り登録</button>;
  } 

  return (
    <div className="text-end mb-2">
      {button}
    </div>
  )
}

export default BookmarkButton;