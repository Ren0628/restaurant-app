import { useContext } from "react";
import { AuthContext } from "../App";
import EditReviewModal from "./EditReviewModal";
import DeleteReviewModal from "./DeleteReviewModal";


function Review({review, setReviews, setMessage, setError}) {

  const authInfo = useContext(AuthContext)[0];

  return (
    <div className="row g-4 mb-3">
      <div className="col-12">
        <div className="card bg-light">
          <div className="card mx-2 my-2">
            <div className="card-body">
              <h6 className="card-subtitle text-muted">{review.updated_at}</h6>
              <div className="card-title mb-0">{review.user?.name}</div>
              <div className="d-flex">
                {[...Array(review.score)].map((obj, index) => {
                  return <img key={index} className="star" src={`http://localhost/laravel-restaurant-app/public/storage/img/star-point.png`} alt="" />
                })}
                {[...Array(5 - review.score)].map((obj, index) => {
                  return <img key={index} className="star" src={`http://localhost/laravel-restaurant-app/public/storage/img/star-no-point.png`} alt="" />
                })}
              </div>
              <p className="card-text">{review.content}</p>
            </div>
          </div>
          { authInfo?.guard === 'user' && review.user_id === authInfo?.auth.id &&
          <>
          <EditReviewModal review={review} setReviews={setReviews} setMessage={setMessage} setError={setError} />
          <DeleteReviewModal review={review} setReviews={setReviews} setMessage={setMessage} setError={setError} />
          <div className="text-end">
            <button className="btn btn-primary mb-2 mx-2" data-bs-toggle="modal" data-bs-target={`#editReviewModal${review.id}`}>編集</button>
            <button className="btn btn-danger mb-2 mx-2" data-bs-toggle="modal" data-bs-target={`#deleteReviewModal${review.id}`}>削除</button>   
          </div>
          </>
          }
          { authInfo?.guard === 'admin' &&
          <>
          <EditReviewModal review={review} setReviews={setReviews} setMessage={setMessage} />
          <DeleteReviewModal review={review} setReviews={setReviews} setMessage={setMessage} />
          <div className="text-end">
            <button className="btn btn-primary mb-2 mx-2" data-bs-toggle="modal" data-bs-target={`#editReviewModal${review.id}`}>編集</button>
            <button className="btn btn-danger mb-2 mx-2" data-bs-toggle="modal" data-bs-target={`#deleteReviewModal${review.id}`}>削除</button>   
          </div>
          </>
          }
        </div>
      </div>
    </div>
  )
}

export default Review;