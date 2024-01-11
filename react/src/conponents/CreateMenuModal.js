import { useState } from 'react';
import axios from 'axios';

function CreateMenuModal({restaurant, setMenus, setMessage, setError}) {

  const [menuName, setMenuName] = useState('');
  const [menuPrice, setMenuPrice] = useState('');

  const handleSubmit = (e) => {
    e.preventDefault();

    const file = new FormData()
    file.append("menu_name", menuName);
    file.append("price", menuPrice);

    axios
    .post(`/api/menus/store/${restaurant.id}`, file)
    .then((res) => {
      if(res.data.status === 200) {
        setMenus(res.data.menus);
        setMessage(res.data.message);
        setMenuName('');
        setMenuPrice('');
        setError('');
      } else {
        setError(res.data.message);
        setMessage('');
      }
    })
  }

  return (
    <div className="modal fade" id="createMenuModal" tabIndex="-1"> 
      <div className="modal-dialog">
        <div className="modal-content">
          <div className="modal-header">
              <h5 className="modal-title">メニュー追加</h5>
              <button type="button" className="btn-close" data-bs-dismiss="modal" aria-label="閉じる"></button>
          </div>
          <div className="modal-body">
            <form onSubmit={handleSubmit}>
              <label htmlFor="menu_name" className="form-label">メニュー名</label>
              <input id="menu_name" type="text" className="form-control" value={menuName} onChange={(e) => {setMenuName(e.target.value)}} />
              <label htmlFor="price" className="form-label">値段</label>
              <input id="price" type="text" className="form-control" value={menuPrice} onChange={(e) => {setMenuPrice(e.target.value)}} />
              <div className="text-end">
                <button type="submit" className="btn btn-primary mt-3" data-bs-dismiss="modal">追加</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  )
}

export default CreateMenuModal