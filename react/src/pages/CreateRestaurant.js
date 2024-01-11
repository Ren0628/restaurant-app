import Content from "../conponents/Content";
import CreateRestaurantForm from "../conponents/CreateRestaurantForm";
import Footer from "../conponents/Footer";
import Header from "../conponents/Header";
import Heading from "../conponents/Heading";


function CreateRestaurant({genres, setRestaurants}) {
  return (
    <>
		<Header />
			<Content>
				<Heading heading="店舗登録" />
				<CreateRestaurantForm genres={genres} setRestaurants={setRestaurants}/>
			</Content>
		<Footer />
    </>
  )
}

export default CreateRestaurant;