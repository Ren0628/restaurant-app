import axios from 'axios';
import { useNavigate } from 'react-router-dom/dist/umd/react-router-dom.development';

function DeleteRestaurantModal({restaurant, setRestaurants}) {

  const navigation = useNavigate();

  const handleSubmit = (e) => {
    e.preventDefault();

    axios
    .post(`/api/restaurants/delete/${restaurant.id}`)
    .then((res) => {
      setRestaurants(res.data.restaurants);
      navigation('/owner/mypage');
    });
  }
  return (
    <div className="modal fade" id="deleteRestaurantModal" tabIndex="-1">
      <div className="modal-dialog">
        <div className="modal-content">
          <div className="modal-header">
            <h5 className="modal-title">「{restaurant.restaurant_name}」<br/>を削除してもよろしいですか？</h5>
            <button type="button" className="btn-close" data-bs-dismiss="modal" aria-label="閉じる"></button>
          </div>
          <div className="modal-footer">
            <form onSubmit={handleSubmit}>
              <button type="submit" className="btn btn-danger" data-bs-dismiss="modal">削除</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  )
}

export default DeleteRestaurantModal