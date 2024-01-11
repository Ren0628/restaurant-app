import { useContext, useState } from "react"
import BackhomeButton from "../conponents/BackHomeButton"
import Content from "../conponents/Content"
import CreateMenuModal from "../conponents/CreateMenuModal"
import Footer from "../conponents/Footer"
import Header from "../conponents/Header"
import Heading from "../conponents/Heading"
import Message from "../conponents/Message"
import RestaurantShow from "../conponents/RestaurantShow"
import { AuthContext } from "../App"
import Review from "../conponents/Review"
import AddReviewButton from "../conponents/AddReviewButton"
import CreateReviewModal from "../conponents/CreateReviewModal"
import BookmarkButton from "../conponents/BookmarkButton"
import DeleteRestaurantButton from "../conponents/DeleteRestaurantButton"
import DeleteRestaurantModal from "../conponents/DeleteRestaurantModal"
import { Link } from "react-router-dom"


function Show({restaurant, menus, setMenus, reviews, setReviews, setRestaurants}) {

  const authInfo = useContext(AuthContext)[0];
  const [message, setMessage] =useState('');
  const [error, setError] = useState('');

  return (
    <>
      <Header />
      <Content >
        <>
          <BackhomeButton />
          {authInfo?.guard === 'owner' && authInfo?.auth.id === restaurant.owner_id &&
          <>
          <div className="text-end">
            <Link className="btn btn-primary mb-2" to={`/owner/editrestaurant`} state={restaurant}>店舗編集</Link>
          </div>
          <DeleteRestaurantModal restaurant={restaurant} setRestaurants={setRestaurants} />
          <DeleteRestaurantButton />
          </>
          }
          {authInfo?.guard === 'user' &&
          <>
          <BookmarkButton restaurant={restaurant} setMessage={setMessage} setRestaurants={setRestaurants} />
          <CreateReviewModal setMessage={setMessage} restaurant={restaurant} setReviews={setReviews} setError={setError} />
          <AddReviewButton />
          </>
          }
          { error &&
          <div className="alert alert-danger my-2">
            <ul>
              {error.menu_name && 
                error.menu_name.map((error) => {
                  return <li key={error}>{error}</li>
                })
              }
              {error.price && 
                error.price.map((error) => {
                  return <li key={error}>{error}</li>
                })
              }
              {error.score && 
                error.score.map((error) => {
                  return <li key={error}>{error}</li>
                })
              }
              {error.content && 
                error.content.map((error) => {
                  return <li key={error}>{error}</li>
                })
              }
            </ul>
          </div>
        }
          <Message message={message} />
          <Heading heading={"店舗情報"} />
          {authInfo?.guard === 'owner' && authInfo?.auth.id === restaurant.owner_id && <CreateMenuModal restaurant={restaurant} setMenus={setMenus} setMessage={setMessage} setError={setError} />}
          {authInfo?.guard === 'admin' && <CreateMenuModal restaurant={restaurant} setMenus={setMenus} setMessage={setMessage} setError={setError} />}
          <RestaurantShow restaurant={restaurant} menus={menus}  setMenus={setMenus} setMessage={setMessage} setError={setError} />
          {reviews?.map((review) => {
            if(review.restaurant_id === restaurant.id) {
              return <Review key={review.id} review={review} setReviews={setReviews} setMessage={setMessage} setError={setError} />
            }
          })}
        </>
      </Content>
      <Footer />
    </>
  )
}

export default Show