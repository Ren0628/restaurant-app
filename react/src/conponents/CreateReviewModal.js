import axios from "axios";
import { useState } from "react"


function CreateReviewModal({restaurant, setMessage, setReviews, setError}) {

  const [score, setScore] = useState('');
  const [content, setContent] =useState('');

  const handleSubmit = (e) => {
    e.preventDefault();

    const file = new FormData()
    file.append("score", score);
    file.append("content", content);

    axios
    .post(`/api/reviews/store/${restaurant.id}`, file)
    .then((res) => {
      if(res.data.status === 200) {
        setReviews(res.data.reviews);
        setMessage(res.data.message);
        setScore('');
        setContent('');
        setError('');
      } else {
        setError(res.data.message);
        setMessage('');
      }
    })
  }

  return (
    <div className="modal fade" id="createReviewModal" tabIndex="-1"> 
      <div className="modal-dialog">
        <div className="modal-content">
          <div className="modal-header">
            <h5 className="modal-title">レビュー投稿</h5>
            <button type="button" className="btn-close" data-bs-dismiss="modal" aria-label="閉じる"></button>
          </div>
          <div className="modal-body">
            <form onSubmit={handleSubmit}>
              <label className="form-label">満足度</label>
              <select name="score" id="score" className="form-select mb-3" value={score} onChange={(e) => {setScore(e.target.value)}}>
                <option disabled value="">選択してください</option>
                <option value="5">5&emsp;とても満足</option>
                <option value="4">4&emsp;満足</option>
                <option value="3">3&emsp;普通</option>
                <option value="2">2&emsp;不満</option>
                <option value="1">1&emsp;とても不満</option>
              </select>
              <label className="form-label">レビュー</label>
              <textarea name="content" id="content" className="form-control mb-3" value={content} onChange={(e) => {setContent(e.target.value)}}></textarea>
              <div className="text-end">
                <button type="submit" className="btn btn-primary" data-bs-dismiss="modal">投稿</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  )
}

export default CreateReviewModal