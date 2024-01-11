<div class="modal fade" id="deleteGenreModal{{ $genre->id }}" tabindex="-1" aria-labeledby="deleteGenreModalLabel{{ $genre->id }}"> 
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteGenreModalLabel{{ $genre->id }}">「{{ $genre->genre }}」を削除してもよろしいですか？</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="閉じる"></button>
            </div>
            <div class="modal-footer">
                <form action="{{ route('genres.delete', $genre) }}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-danger">削除</button>
                </form>
            </div>
        </div>
    </div>
</div>