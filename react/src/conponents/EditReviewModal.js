import axios from "axios";
import { useState } from "react"

function EditReviewModal({review, setReviews, setMessage, setError}) {

    const [score, setScore] = useState(review.score);
    const [content, setContent] =useState(review.content);
  
    const handleSubmit = (e) => {
      e.preventDefault();
  
      const file = new FormData()
      file.append("score", score);
      file.append("content", content);
  
      axios
      .post(`/api/reviews/update/${review.id}`, file)
      .then((res) => {
        if(res.data.status === 200) {
          setReviews(res.data.reviews);
          setMessage(res.data.message);
          setError('');
        } else {
          setError(res.data.message);
          setMessage('');
        }
      })
    }

  return (
    <div className="modal fade" id={`editReviewModal${review.id}`} tabIndex="-1"> 
      <div className="modal-dialog">
        <div className="modal-content">
          <div className="modal-header">
            <h5 className="modal-title">レビュー編集</h5>
            <button type="button" className="btn-close" data-bs-dismiss="modal" aria-label="閉じる"></button>
          </div>
          <div className="modal-body">
            <form onSubmit={handleSubmit}>
              <label className="form-label">満足度</label>
              <select name="score" id="score" className="form-select mb-3" defaultValue={review.score} onChange={(e) => {setScore(e.target.value)}}>
                <option disabled value="0">選択してください</option>
                <option value="5">5&emsp;とても満足</option>
                <option value="4">4&emsp;満足</option>
                <option value="3">3&emsp;普通</option>
                <option value="2">2&emsp;不満</option>
                <option value="1">1&emsp;とても不満</option>
              </select>
              <label className="form-label">レビュー</label>
              <textarea name="content" id="content" className="form-control mb-3" defaultValue={review.content} onChange={(e) => {setContent(e.target.value)}}></textarea>
              <div className="text-end">
                <button type="submit" className="btn btn-primary" data-bs-dismiss="modal">更新</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  )
}

export default EditReviewModal