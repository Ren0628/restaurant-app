<div class="modal fade" id="deleteModal" tabindex="-1" aria-labeledby="deleteModalLabel"> 
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">「{{ $restaurant->restaurant_name }}」を削除してもよろしいですか？</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="閉じる"></button>
            </div>
            <div class="modal-footer">
                @if(Auth::guard('owner')->check() && Auth::id() === $restaurant->owner_id)
                <form action="{{ route('owner.delete', $restaurant) }}" method="post">
                @elseif (Auth::guard('admin')->check())
                <form action="{{ route('admin.delete', $restaurant) }}" method="post">
                @endif
                    @csrf
                    <button type="submit" class="btn btn-danger">削除</button>
                </form>
            </div>
        </div>
    </div>
</div>