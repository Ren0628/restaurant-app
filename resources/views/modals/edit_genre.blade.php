<div class="modal fade" id="editGenreModal{{ $genre->id }}" tabindex="-1" aria-labeledby="editGenreModalLabel{{ $genre->id }}"> 
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editGenreModalLabel{{ $genre->id }}">ジャンル編集</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="閉じる"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('genres.update', $genre) }}" method="post">
                    @csrf
                    <input type="text" name="genre" class="form-control" value="{{ $genre->genre }}">
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary mt-3">更新</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>