import { useState } from "react";
import Content from "../conponents/Content";
import Footer from "../conponents/Footer";
import Header from "../conponents/Header";
import RegisterForm from "../conponents/RegisterForm";


function Register({authgroup, url}) {

  const [message, setMessage] = useState();

  return (
    <>
		<Header />
			<Content>
      { message &&
          <div className="alert alert-danger">
            <ul>
              {typeof message === 'string' &&
                <li>{message}</li>
              }
              {message.name && 
                message.name.map((error) => {
                  return <li key={error}>{error}</li>
                })
              }
              {message.email && 
                message.email.map((error) => {
                  return <li key={error}>{error}</li>
                })
              }
              {message.password && 
                message.password.map((error) => {
                  return <li key={error}>{error}</li>
                })
              }
            </ul>
          </div>
        }
				<RegisterForm authgroup={authgroup} url={url} setMessage={setMessage} />
			</Content>
		<Footer />
    </>
  )
}

export default Register;