import { useState } from 'react';
import axios from 'axios';

function EditGenreModal({genreName, genreId, setGenres, setMessage, setError}) {

  const [genre, setGenre] = useState(genreName);

  const handleSubmit = (e) => {
    e.preventDefault();

    const file = new FormData()
    file.append("genre", genre);

    axios
    .post(`/api/genres/update/${genreId}`, file)
    .then((res) => {
      if(res.data.status === 200) {
        setGenres(res.data.genres);
        setMessage(res.data.message);
        setError('');
      } else {
        setError(res.data.message);
        setMessage('');
      }
    })
  }

  return (
    <div className="modal fade" id={`editGenreModal${genreId}`} tabIndex="-1">
      <div className="modal-dialog">
        <div className="modal-content">
          <div className="modal-header">
              <h5 className="modal-title">ジャンル編集</h5>
              <button type="button" className="btn-close" data-bs-dismiss="modal" aria-label="閉じる"></button>
          </div>
          <div className="modal-body">
            <form onSubmit={handleSubmit}>
              <input type="text" className="form-control" defaultValue={genreName} onChange={(e) => {setGenre(e.target.value)}} />
              <div className="text-end">
                <button type="submit" className="btn btn-primary mt-3" data-bs-dismiss="modal">更新</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  )
}

export default EditGenreModal