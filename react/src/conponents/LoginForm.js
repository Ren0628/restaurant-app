import BackHomeButton from "./BackHomeButton";
import { useNavigate } from 'react-router-dom';
import axios from 'axios';
import { useContext, useState } from 'react';
import { AuthContext } from "../App";

function LoginForm({authgroup, url, setMessage}) {

  const setAuthInfo = useContext(AuthContext)[1];

  const navigation = useNavigate();

  const [loginInput, setLogin] = useState({
    email: '',
    password: '',
  });

  const handleInput = (e) => {
    e.persist();
    setLogin({...loginInput, [e.target.name]: e.target.value});
  }

  const loginSubmit = (e) => {
    e.preventDefault();

    const data = {
      email: loginInput.email,
      password: loginInput.password,
    }

    axios.get('/sanctum/csrf-cookie').then((res) => {
      axios.post(url, data).then(res => {
        if(res.data.status === 200) {
          setAuthInfo(res.data);
          navigation('/');
        } else {
          setMessage(res.data.message);
        }
      });
    });
}

  return (
    <>
      <BackHomeButton />
      <div className="row justify-content-center">
        <div className="col-md-8">
          <div className="card">
            <div className="card-header">{authgroup}ログイン</div>
            <div className="card-body">
              <form onSubmit={loginSubmit}>
                <div className="row mb-3">
                    <label className="col-md-4 col-form-label text-md-end">メールアドレス</label>
                  <div className="col-md-6">
                    <input id="email" type="email" className="form-control " name="email" required onChange={handleInput} value={loginInput.email} />
                  </div>
                </div>
                <div className="row mb-3">
                  <label className="col-md-4 col-form-label text-md-end">パスワード</label>
                  <div className="col-md-6">
                    <input id="password" type="password" className="form-control " name="password" required onChange={handleInput} value={loginInput.password} />
                  </div>
                </div>
                <div className="row mb-0">
                  <div className="col-md-8 offset-md-4">
                    <button type="submit" className="btn btn-primary">
                      ログイン
                    </button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </>
  )
}

export default LoginForm;