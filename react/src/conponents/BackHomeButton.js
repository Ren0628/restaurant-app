import { useNavigate } from "react-router-dom";

function BackhomeButton() {
  
  const navigation = useNavigate();

  const handleClick= () => {
    navigation(-1);
  }

  return (
    <div className="btn btn-primary" onClick={handleClick}>&lt; 戻る</div>
  )
}

export default BackhomeButton;