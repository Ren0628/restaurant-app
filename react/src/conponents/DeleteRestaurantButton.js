

function DeleteRestaurantButton() {
  return (
    <div className="text-end">
      <button className="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteRestaurantModal">店舗削除</button>
    </div>
  )
}

export default DeleteRestaurantButton