
function Genre(props) {
  return (
    <div className="col-12 col-md-6 d-flex justify-content-between p-2 border">
        <div className="fs-4">{props.genre}</div>
        <div>
            <button className="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target={'#editGenreModal' + props.id}>編集</button>
            <button className="btn btn-danger" data-bs-toggle="modal" data-bs-target={'#deleteGenreModal' + props.id}>削除</button>
        </div>
    </div>
  )
}

export default Genre