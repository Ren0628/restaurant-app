import Card from "./Card"


function CardWrap({restaurants}) {
  return (
    <div className="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        {restaurants?.map((restaurant) => {
          return (<Card key={restaurant.id} restaurant={restaurant} />)
        })}
    </div>
  )
}

export default CardWrap