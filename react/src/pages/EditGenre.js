import BackhomeButton from "../conponents/BackHomeButton";
import Content from "../conponents/Content";
import Footer from "../conponents/Footer";
import Genre from "../conponents/Genre";
import Header from "../conponents/Header";
import Heading from "../conponents/Heading";
import GenresWrap from "../conponents/GenresWrap";
import AddGenreButton from "../conponents/AddGenreButton";
import CreateGenreModal from "../conponents/CreateGenreModal";
import EditGenreModal from "../conponents/EditGenreModal";
import { Fragment, useState } from "react";
import DeleteGenreModal from "../conponents/DeleteGenreModal";
import Message from "../conponents/Message";
import ErrorMessage from "../conponents/ErrorMessage";

function EditGenre({genres, setGenres}) {
const [message, setMessage] = useState();
const [error, setError] = useState();

  return (
    <>
      <Header />
      <Content >
        <>
          <CreateGenreModal setGenres={setGenres} setMessage={setMessage} setError={setError} />
          <BackhomeButton />
          <AddGenreButton />
          <Message message={message} />
          <ErrorMessage error={error} />
          <Heading heading="ジャンル一覧" />
          <GenresWrap>
            {genres?.map((genre) => {
              return (
                <Fragment key={genre.id}>
                  <DeleteGenreModal genreName={genre.genre} genreId={genre.id} setGenres={setGenres} setMessage={setMessage} setError={setError} />
                  <EditGenreModal genreName={genre.genre} genreId={genre.id}  setGenres={setGenres} setMessage={setMessage} setError={setError} />
                  <Genre genre={genre.genre} id={genre.id} />
                </Fragment>
              )
            })}
          </GenresWrap>
        </>
      </Content>
      <Footer />
    </>
  )
}
  
export default EditGenre;