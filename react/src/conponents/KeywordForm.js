import axios from "axios";


function KeywordForm({genres, setRestaurants, keyword, setKeyword, genre, setGenre}) {

  const handleSubmit = (e) => {
    e.preventDefault();

    const file = new FormData()

    file.append("keyword", keyword);
    file.append("genre", genre);

    axios
      .post(`/api/restaurants/keyword`, file)
      .then((res) => {
        setRestaurants(res.data.restaurants);
      });

  }

  return (
    <form onSubmit={handleSubmit}>
      <div className="input-group mb-3">
        <input type="text" className="form-control" placeholder="キーワードを入力" name="keyword" value={keyword} onChange={(e) => {setKeyword(e.target.value)}} />
        <select className="form-select" name="genre" onChange={(e) => {setGenre(e.target.value)}} value={genre}>
          <option value="">ジャンル選択</option>
          {genres?.map((genre) => {
            return <option key={genre.id} value={genre.genre}>{genre.genre}</option>
          })}
        </select>
      <button className="btn btn-outline-success me-3" type="submit"><i className="fas fa-search"></i> 検索</button>
      </div>
    </form>
  )
}

export default KeywordForm