import { useLocation } from "react-router-dom"
import Content from "../conponents/Content"
import EditRestaurantForm from "../conponents/EditRestaurantForm"
import Footer from "../conponents/Footer"
import Header from "../conponents/Header"
import Heading from "../conponents/Heading"
import BackhomeButton from "../conponents/BackHomeButton"


function EditRestaurant({genres, setRestaurants}) {

  const location = useLocation();
  const restaurant = location.state;

  return (
    <>
		<Header />
			<Content>
        <BackhomeButton />
				<Heading heading="店舗編集" />
				<EditRestaurantForm genres={genres} setRestaurants={setRestaurants} restaurant={restaurant} />
			</Content>
		<Footer />
    </>
  )
}

export default EditRestaurant