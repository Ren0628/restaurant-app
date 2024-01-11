import axios from 'axios';

function DeleteMenuModal({menu, setMenus, setMessage, setError}) {

  const handleSubmit = (e) => {
    e.preventDefault();

    axios
    .post(`/api/menus/delete/${menu.id}`)
    .then((res) => {
      setMenus(res.data.menus);
      setMessage(res.data.message);
      setError('');
    })
  }

  return (
    <div className="modal fade" id={`deleteMenuModal${menu.id}`} tabIndex="-1"> 
      <div className="modal-dialog">
        <div className="modal-content">
          <div className="modal-header">
              <h5 className="modal-title">「{menu.menu_name}」を削除してもよろしいですか？</h5>
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

export default DeleteMenuModal;