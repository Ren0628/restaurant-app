import axios from 'axios';

function DeleteGenreModal({genreName, genreId, setGenres, setMessage, setError}) {

  const handleSubmit = (e) => {
    e.preventDefault();

    axios
    .post(`/api/genres/delete/${genreId}`)
    .then((res) => {
      setGenres(res.data.genres);
      setMessage(res.data.message);
      setError('');
    });
  }

  return (
    <div className="modal fade" id={`deleteGenreModal${genreId}`} tabIndex="-1"> 
      <div className="modal-dialog">
        <div className="modal-content">
          <div className="modal-header">
              <h5 className="modal-title">「{genreName}」を削除してもよろしいですか？</h5>
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

export default DeleteGenreModal;