import axios from "axios";
import { useState } from "react";
import { useNavigate } from "react-router-dom";

function EditRestaurantForm({genres, setRestaurants, restaurant}) {

    const navigation = useNavigate();

    const [imgPath, setImgPath] = useState();
    const [restaurantName, setRestaurantName] = useState(restaurant.restaurant_name);
    const [introduction, setIntroduction] = useState(restaurant.introduction);
    const [genre, setGenre] = useState(restaurant.genre);
    const [budget, setBudget] = useState(restaurant.budget);
    const [phone, setPhone] = useState(restaurant.phone);
    const [address, setAddress] = useState(restaurant.address);
    const [access, setAccess] = useState(restaurant.access);
  
    const handleSubmit = (e) => {
      e.preventDefault();
  
      const file = new FormData()
      file.append("img_path", imgPath[0]);
      file.append("restaurant_name", restaurantName);
      file.append("introduction", introduction);
      file.append("genre", genre);
      file.append("budget", budget);
      file.append("phone", phone);
      file.append("address", address);
      file.append("access", access);
      
      axios
      .post(`/api/restaurants/update/${restaurant.id}`, file)
      .then((res) => {
        setRestaurants(res.data.restaurants);
        navigation(`/show/${restaurant.id}`);
      });
    }

  return (
    <div className="row row-cols-1 row-cols-md-2 justify-content-center">
      <form onSubmit={handleSubmit}>
        <div className="mb-3 d-flex justify-content-between align-items-center">
          <div className="me-2">
            <label className="form-label">お店の画像</label>
            <input className="form-control" type="file" multiple name="img_path" onChange={(e) => {setImgPath(e.target.files)}} required />
          </div>
          <div className="edit_restaurant_img">
            <span>現在の画像</span>
            <img src={`http://localhost/laravel-restaurant-app/public/storage/${restaurant.img_path}`} alt="" />
          </div>
        </div>
        <div className="mb-3">
          <label className="form-label">店名</label>
          <input className="form-control" type="text" name="restaurant_name" onChange={(e) => {setRestaurantName(e.target.value)}} defaultValue={restaurant.restaurant_name} required />
        </div>
        <div className="mb-3">
          <label className="form-label">紹介文</label>
          <textarea className="form-control" name="introduction" onChange={(e) => {setIntroduction(e.target.value)}} defaultValue={restaurant.introduction} required></textarea>
        </div>
        <div className="mb-3">
          <label className="form-label">料理ジャンル</label>
          <select name="genre" className="form-select mb-3" defaultValue={restaurant.genre} onChange={(e) => {setGenre(e.target.value)}} required >
            <option disabled value="disable">選択してください</option>
            {genres?.map((genre) => {
              return <option key={genre.id} value={genre.genre}>{genre.genre}</option>
            })}
          </select>
        </div>
        <div className="mb-3">
          <label className="form-label">価格帯</label>
          <input className="form-control" type="text" name="budget" onChange={(e) => {setBudget(e.target.value)}} defaultValue={restaurant.budget} required/>
        </div>
        <div className="mb-3">
          <label className="form-label">電話番号</label>
          <input className="form-control" type="text" name="phone" onChange={(e) => {setPhone(e.target.value)}} defaultValue={restaurant.phone} required />
        </div>
        <div className="mb-3">
          <label className="form-label">住所</label>
          <input className="form-control" type="text" name="address" onChange={(e) => {setAddress(e.target.value)}} defaultValue={restaurant.address} required />
        </div>
        <div className="mb-3">
          <label className="form-label">アクセス</label>
          <input className="form-control" type="text" name="access" onChange={(e) => {setAccess(e.target.value)}} defaultValue={restaurant.access} required />
        </div>
        <div className="text-end">
          <button type="submit" className="btn btn-primary">更新</button>
        </div>
      </form>
    </div>
  )
}

export default EditRestaurantForm