import { useState } from 'react';
import axios from 'axios';

function CreateGenreModal({setGenres, setMessage, setError}) {

  const [genre, setGenre] = useState('');


  const handleSubmit = (e) => {
    e.preventDefault();
    
    const file = new FormData()
    file.append("genre", genre);

    axios
    .post("/api/genres/store", file)
    .then((res) => {
      if(res.data.status === 200) {
        setGenres(res.data.genres);
        setMessage(res.data.message);
        setGenre('');
        setError('');
      } else {
        setError(res.data.message);
        setMessage('');
      }
    })
  }

  return (
    <div className="modal fade" id="createGenreModal" tabIndex="-1"> 
      <div className="modal-dialog">
        <div className="modal-content">
            <div className="modal-header">
                <h5 className="modal-title">ジャンル追加</h5>
                <button type="button" className="btn-close" data-bs-dismiss="modal" aria-label="閉じる"></button>
            </div>
            <div className="modal-body">
                <form onSubmit={handleSubmit}>
                    <input type="text" className="form-control" onChange={(e) => {setGenre(e.target.value)}} value={genre} />
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

export default CreateGenreModal