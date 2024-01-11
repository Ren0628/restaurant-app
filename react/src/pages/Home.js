import CardWrap from "../conponents/CardWrap";
import Content from "../conponents/Content";
import Footer from "../conponents/Footer";
import Header from "../conponents/Header";
import SearchForm from "../conponents/SearchForm";

function Home({ restaurants, genres, setRestaurants }) {
    return (
      <>
        <Header />
        <Content >
          <>
            <SearchForm genres={genres} setRestaurants={setRestaurants} />
            <CardWrap restaurants={restaurants} />
          </>
        </Content>
        <Footer />
      </>
    )
  }
  
  export default Home;