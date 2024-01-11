import axios from "axios";
import { useState } from "react";
import { useNavigate } from "react-router-dom";


function CreateRestaurantForm({genres, setRestaurants}) {

  const navigation = useNavigate();

  const [imgPath, setImgPath] = useState();
  const [restaurantName, setRestaurantName] = useState();
  const [introduction, setIntroduction] = useState();
  const [genre, setGenre] = useState();
  const [budget, setBudget] = useState();
  const [phone, setPhone] = useState();
  const [address, setAddress] = useState();
  const [access, setAccess] = useState();

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
    .post(`/api/restaurants/store`, file)
    .then((res) => {
      setRestaurants(res.data.restaurants);
      navigation('/owner/mypage');
    });
  }

  return (
    <div className="row row-cols-1 row-cols-md-2 justify-content-center">
      <form onSubmit={handleSubmit}>
        <div className="mb-3">
            <label className="form-label">お店の画像</label>
            <input className="form-control" type="file" multiple name="img_path" onChange={(e) => {setImgPath(e.target.files)}} required />
        </div>
        <div className="mb-3">
            <label className="form-label">店名</label>
            <input className="form-control" type="text" name="restaurant_name" onChange={(e) => {setRestaurantName(e.target.value)}} required />
        </div>
        <div className="mb-3">
            <label className="form-label">紹介文</label>
            <textarea className="form-control" name="introduction" onChange={(e) => {setIntroduction(e.target.value)}} required></textarea>
        </div>
        <div className="mb-3">
            <label className="form-label">料理ジャンル</label>
            <select name="genre" className="form-select mb-3" defaultValue={"disable"}  onChange={(e) => {setGenre(e.target.value)}} required>
                <option disabled value="disable">選択してください</option>
                {genres?.map((genre) => {
                  return <option key={genre.id} value={genre.genre}>{genre.genre}</option>
                })}
            </select>
        </div>
        <div className="mb-3">
            <label className="form-label">価格帯</label>
            <input className="form-control" type="text" name="budget" onChange={(e) => {setBudget(e.target.value)}} required />
        </div>
        <div className="mb-3">
            <label className="form-label">電話番号</label>
            <input className="form-control" type="text" name="phone" onChange={(e) => {setPhone(e.target.value)}} required />
        </div>
        <div className="mb-3">
            <label className="form-label">住所</label>
            <input className="form-control" type="text" name="address" onChange={(e) => {setAddress(e.target.value)}} required />
        </div>
        <div className="mb-3">
            <label className="form-label">アクセス</label>
            <input className="form-control" type="text" name="access" onChange={(e) => {setAccess(e.target.value)}} required />
        </div>
        <div className="text-end">
          <button type="submit" className="btn btn-primary">登録</button>
        </div>
      </form>
    </div>
  )
}

export default CreateRestaurantForm;