<div class="modal fade" id="deleteReviewModal{{ $review->id }}" tabindex="-1" aria-labeledby="deleteReviewModalLabel{{ $review->id }}"> 
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteReviewModalLabel{{ $review->id }}">「{{ $review->content }}」を削除してもよろしいですか？</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="閉じる"></button>
            </div>
            <div class="modal-footer">
                <form action="{{ route('delete-review', [$review, $restaurant]) }}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-danger">削除</button>
                </form>
            </div>
        </div>
    </div>
</div>