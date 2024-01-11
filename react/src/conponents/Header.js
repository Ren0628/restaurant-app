import { Link } from "react-router-dom";
import axios from 'axios';
import { useNavigate } from 'react-router-dom';
import { useContext } from "react";
import { AuthContext } from "../App";

function Header() {

  const [authInfo, setAuthInfo] = useContext(AuthContext);

  const url = `/api/${authInfo.guard}/logout`;

  const navigation = useNavigate();

  const logoutSubmit = (e) => {
    e.preventDefault();

    axios.post(url).then((res) => {
      setAuthInfo(res.data);
      navigation('/');
    });
  }

  let headerMenuList;

  if(authInfo.auth === '' || authInfo.auth === undefined) {
    headerMenuList = (
      <>
        <Link className="dropdown-item" to={`/`}>ホーム</Link>
        <div className="dropdown-divider"></div>
        <Link className="dropdown-item" to={`/user/login`}>ユーザーログイン</Link>
        <div className="dropdown-divider"></div>
        <Link className="dropdown-item" to={`/user/register`}>ユーザー新規登録</Link>
        <div className="dropdown-divider"></div>
        <Link className="dropdown-item" to={`/owner/login`}>オーナーログイン</Link>
        <div className="dropdown-divider"></div>
        <Link className="dropdown-item" to={`/owner/register`}>オーナー新規登録</Link>
      </>
    )
  } else if(authInfo?.guard === "admin") {
    headerMenuList = (
      <>
        <Link className="dropdown-item" to={`/`}>ホーム</Link>
        <div className="dropdown-divider"></div>
        <Link className="dropdown-item" to={`/admin/editGenre`}>ジャンル管理ページ</Link>
        <div className="dropdown-divider"></div>
        <div className="dropdown-item" onClick={logoutSubmit}>ログアウト</div>
      </>
    )
  } else if(authInfo?.guard === "owner") {
    headerMenuList = (
      <>
        <Link className="dropdown-item" to={`/`}>ホーム</Link>
        <div className="dropdown-divider"></div>
        <Link className="dropdown-item" to={`/owner/mypage`}>オーナーマイページ</Link>
        <div className="dropdown-divider"></div>
        <Link className="dropdown-item" to={`/owner/createrestaurant`}>店舗登録</Link>
        <div className="dropdown-divider"></div>
        <div className="dropdown-item" onClick={logoutSubmit}>ログアウト</div>
      </>
    )
  } else if(authInfo?.guard === "user") {
    headerMenuList = (
      <>
        <Link className="dropdown-item" to={`/`}>ホーム</Link>
        <div className="dropdown-divider"></div>
        <Link className="dropdown-item" to={`/user/mypage`}>ユーザーマイページ</Link>
        <div className="dropdown-divider"></div>
        <div className="dropdown-item" onClick={logoutSubmit}>ログアウト</div>
      </>
    )
  }

  return (
    <header className="fixed-top"> 
      <nav className="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div className="container">
          <Link to={`/`} className="navbar-brand">レストラン</Link>
          <div>{authInfo.auth?.name}</div>
          <button className="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
              <span className="navbar-toggler-icon"></span>
          </button>
          <div className="collapse navbar-collapse" id="navbarSupportedContent">
            <ul className="navbar-nav me-auto">
            </ul>    
            <ul className="navbar-nav ms-auto">
              <li className="nav-item dropdown">
                <div id="navbarDropdown" className="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                  MENU
                </div>
                <div className="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    {headerMenuList}
                </div>
              </li>     
            </ul>
          </div>
        </div>
      </nav>
    </header> 
  )
}

export default Header;