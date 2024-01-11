import { Routes, Route, Navigate } from 'react-router-dom';
import Home from './pages/Home';
import Login from './pages/Login';
import Register from './pages/Register';
import EditGenre from './pages/EditGenre';
import { createContext, useEffect, useState } from 'react';
import axios from 'axios';
import Show from './pages/Show';
import CreateRestaurant from './pages/CreateRestaurant';
import EditRestaurant from './pages/EditRestaurant';


axios.defaults.baseURL = "http://localhost/laravel-restaurant-app/public/";
axios.defaults.withCredentials = true;
// axios.interceptors.request.use(function(config){
//   const token = localStorage.getItem('auth_token');
//   config.headers.Authorization = token ? `Bearer ${token}` : '';
//   return config;
// });


export const AuthContext = createContext();

function App() {

  // isLogin
  const [authInfo, setAuthInfo] = useState('');
  useEffect(() => {
    (async () => {
      try{
        const res = await axios.get('/api/auth');
        setAuthInfo(res.data);
      } catch(e) {
        return e;
      }
    })();
  }, []);

  //Genre Api 
  const [genres, setGenres] = useState();
  const genresUrl = "/api/genres";
  
  useEffect(() => {
    (async () => {
      try{
        const genresRes = await axios.get(genresUrl);
        setGenres(genresRes.data.genres);
      } catch(e) {
        return e;
      }
    })();
  }, []);

  // Restaurant Api
  const [restaurants, setRestaurants] = useState();
  const restaurantsUrl = "/api/restaurants";

  useEffect(() => {
    (async () => {
      try{
        const restaurantsRes = await axios.get(restaurantsUrl);
        setRestaurants(restaurantsRes.data.restaurants);
      } catch(e) {
        return e;
      }
    })();
  }, []);

  // Menu Api
  const [menus, setMenus] = useState();
  const menusUrl = "/api/menus";

  useEffect(() => {
    (async () => {
      try{
        const menusRes = await axios.get(menusUrl);
        setMenus(menusRes.data.menus);
      } catch(e) {
        return e;
      }
    })();
  }, []);

  // Review Api
  const [reviews, setReviews] = useState();
  
  useEffect(() => {
    (async () => {
      try{
        const res = await axios.get('/api/reviews');
        setReviews(res.data.reviews);
      } catch(e) {
        return e;
      }
    })();
  }, []);

  const ownerRestaurants = restaurants?.filter((restaurant) => {
    if(authInfo?.guard ==='owner' && restaurant.owner_id === authInfo?.auth.id) {
      return restaurant;
    }
  });

  
  const userRestaurants = restaurants?.filter((restaurant) => {
    try {
    const isBookmarked = restaurant.users?.some((element) => {
      return element?.id === authInfo?.auth.id;
    })
    
    if(authInfo?.guard ==='user' && isBookmarked) {
      return restaurant;
    }
    } catch(e) {

    }
  });


  return (
    <AuthContext.Provider value={[authInfo, setAuthInfo]}>
      <Routes>

        <Route path="/" element={<Home restaurants={restaurants} genres={genres} setRestaurants={setRestaurants} />} />
        
        {restaurants?.map((restaurant) => {
          return (<Route key={restaurant.id} path={`/show/${restaurant.id}`} element={<Show restaurant={restaurant} menus={menus} setMenus={setMenus} reviews={reviews} setReviews={setReviews} setRestaurants={setRestaurants} />} />)
        })}

        <Route path="/admin/login" element={
          authInfo.auth === ''
          ? <Login authgroup="管理者" url="api/admin/login" />
          : authInfo?.auth === undefined
          ? <></>
          : <Navigate replace to="/" />
        }/>
        <Route path="/user/login" element={
          authInfo.auth === ''
          ? <Login authgroup="ユーザー" url="api/user/login" />
          : authInfo?.auth === undefined
          ? <></>
          : <Navigate replace to="/" />
        }/>
        <Route path="/user/register" element={
          authInfo.auth === ''
          ? <Register authgroup="ユーザー" url="api/user/register" />
          : authInfo?.auth === undefined
          ? <></>
          : <Navigate replace to="/" />
        }/>
        <Route path="/owner/login" element={
          authInfo.auth === ''
          ? <Login authgroup="オーナー" url="api/owner/login" />
          : authInfo?.auth === undefined
          ? <></>
          : <Navigate replace to="" />
        }/>
        <Route path="/owner/register" element={
          authInfo.auth === ''
          ? <Register authgroup="オーナー" url="api/owner/register" />
          : authInfo?.auth === undefined
          ? <></>
          : <Navigate replace to="/" />
        }/>

        <Route path="/user/mypage" element={
          authInfo?.guard === 'user'
          ? <Home restaurants={userRestaurants} genres={genres} setRestaurants={setRestaurants} />
          : authInfo?.guard === undefined 
          ? <></>
          : <Navigate replace to="/user/login" />
        }/>

        <Route path="/owner/mypage" element={
          authInfo?.guard === 'owner'
          ? <Home restaurants={ownerRestaurants} genres={genres} setRestaurants={setRestaurants} />
          : authInfo?.guard === undefined 
          ? <></>
          : <Navigate replace to="/owner/login" />
        }/>

        <Route path="/owner/createrestaurant" element={
          authInfo?.guard === 'owner'
          ? <CreateRestaurant genres={genres} setRestaurants={setRestaurants}/>
          : authInfo?.guard === undefined 
          ? <></>
          : <Navigate replace to="/owner/login" />
        }/>

        <Route path="/owner/editrestaurant" element={
          authInfo?.guard === 'owner'
          ? <EditRestaurant genres={genres} setRestaurants={setRestaurants}/>
          : authInfo?.guard === undefined 
          ? <></>
          : <Navigate replace to="/owner/login" />
        }/>

        <Route path="/admin/editGenre" element={
          authInfo?.guard === 'admin'
          ? <EditGenre genres={genres} setGenres={setGenres} />
          : authInfo?.guard === undefined 
          ? <></>
          : <Navigate replace to="/admin/login" />
        }/>

      </Routes>
    </AuthContext.Provider>
  )
}

export default App;