import { useContext } from "react"
import DeleteMenuModal from "./DeleteMenuModal"
import EditMenuModal from "./EditMenuModal"
import { AuthContext } from "../App"


function RestaurantShow({restaurant, menus, setMenus, setMessage, setError}) {

  const authInfo = useContext(AuthContext)[0];

  return (
    <div className="row justify-content-center mb-3 restaurant-show">
      <div className="col-12 col-md-10">
        <div className="card">
            <img src={`http://localhost/laravel-restaurant-app/public/storage/${restaurant.img_path}`} className="card-img-top" alt="..." />
            <div className="card-body">
                <p className="card-text fs-5">{restaurant.genre}</p>
                <h5 className="card-title fs-1">{restaurant.restaurant_name}</h5>
                <p className="card-text fs-5">{restaurant.introduction}</p>
            </div>
            <ul className="list-group list-group-flush">
                <li className="list-group-item">価格帯&emsp;{restaurant.budget}</li>
                <li className="list-group-item">
                  {authInfo?.guard === 'owner' && authInfo?.auth.id === restaurant.owner_id && <button className="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createMenuModal">メニュー追加</button>}
                  {authInfo?.guard === 'admin' && <button className="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createMenuModal">メニュー追加</button>}
                  <details>
                      <summary>メニュー一覧</summary>
                      {menus?.map((menu) => {
                        if(menu.restaurant_id === restaurant.id) {
                          return (
                            <div key={menu.id} className="d-flex my-2">
                              <div className="fs-5">{menu.menu_name}:{menu.price}</div>
                              {authInfo?.guard === 'owner' && authInfo?.auth.id === restaurant.owner_id &&
                              <>
                                <EditMenuModal menu={menu} setMenus={setMenus} setMessage={setMessage} setError={setError} />
                                <DeleteMenuModal menu={menu} setMenus={setMenus} setMessage={setMessage} setError={setError} />
                                <button className="btn btn-primary mx-2" data-bs-toggle="modal" data-bs-target={`#editMenuModal${menu.id}`}>編集</button>
                                <button className="btn btn-danger" data-bs-toggle="modal" data-bs-target={`#deleteMenuModal${menu.id}`}>削除</button>
                              </>
                              }
                              {authInfo?.guard === 'admin' &&
                              <>
                                <EditMenuModal menu={menu} setMenus={setMenus} setMessage={setMessage} />
                                <DeleteMenuModal menu={menu} setMenus={setMenus} setMessage={setMessage} />
                                <button className="btn btn-primary mx-2" data-bs-toggle="modal" data-bs-target={`#editMenuModal${menu.id}`}>編集</button>
                                <button className="btn btn-danger" data-bs-toggle="modal" data-bs-target={`#deleteMenuModal${menu.id}`}>削除</button>
                              </>
                              }
                            </div>
                          )
                        }
                      })}
                  </details>
                </li>
                <li className="list-group-item">電話番号&emsp;{restaurant.phone}</li>
                <li className="list-group-item">住所&emsp;{restaurant.address}</li>
                <li className="list-group-item">アクセス&emsp;{restaurant.access}</li>
            </ul>
        </div>
      </div>
    </div>
  )
}

export default RestaurantShow