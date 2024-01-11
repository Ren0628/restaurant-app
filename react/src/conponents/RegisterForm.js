import BackhomeButton from "./BackHomeButton";
import { useNavigate } from 'react-router-dom';
import axios from 'axios';
import { useContext, useState } from 'react';
import { AuthContext } from "../App";


function RegisterForm({authgroup, url, setMessage}) {

  const setAuthInfo = useContext(AuthContext)[1];

  const navigation = useNavigate();

    const [registerInput, setRegister] = useState({
      name: '',
      email: '',
      password: '',
      password_confirmation: '',
    });

    const handleInput = (e) => {
      e.persist();
      setRegister({...registerInput, [e.target.name]: e.target.value });
    }

    const registerSubmit = (e) => {
      e.preventDefault();

      if(registerInput.password !== registerInput.password_confirmation) {
        setMessage('パスワードが一致していません。');
      } else {
        const data = {
          name: registerInput.name,
          email: registerInput.email,
          password: registerInput.password,
        }

        axios.get('/sanctum/csrf-cookie').then(response => {
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
    }

  return (
    <>
      <BackhomeButton />
      <div className="row justify-content-center">
        <div className="col-md-8">
          <div className="card">
            <div className="card-header">{authgroup}新規登録</div>
            <div className="card-body">
              <form onSubmit={registerSubmit}>
                <div className="row mb-3">
                  <label className="col-md-4 col-form-label text-md-end">ユーザー名</label>
                  <div className="col-md-6">
                      <input id="name" type="text" className="form-control" name="name" required onChange={handleInput} value={registerInput.name} />
                  </div>
                </div>
                <div className="row mb-3">
                  <label className="col-md-4 col-form-label text-md-end">メールアドレス</label>

                  <div className="col-md-6">
                      <input id="email" type="email" className="form-control" name="email" required onChange={handleInput} value={registerInput.email} />
                  </div>
                </div>

                <div className="row mb-3">
                  <label className="col-md-4 col-form-label text-md-end">パスワード</label>

                  <div className="col-md-6">
                      <input id="password" type="password" className="form-control" name="password" required onChange={handleInput} value={registerInput.password} />
                  </div>
                </div>

                <div className="row mb-3">
                  <label className="col-md-4 col-form-label text-md-end">パスワード（確認用）</label>
                  <div className="col-md-6">
                      <input id="password-confirm" type="password" className="form-control" name="password_confirmation" required onChange={handleInput} />
                  </div>
                </div>
                <div className="row mb-0">
                  <div className="col-md-6 offset-md-4">
                    <button type="submit" className="btn btn-primary">
                        新規登録
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

export default RegisterForm;