<div class="modal fade" id="createGenreModal" tabindex="-1" aria-labeledby="createGenreModalLabel"> 
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createGenreModalLabel">ジャンル追加</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="閉じる"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('genres.store') }}" method="post">
                    @csrf
                    <input type="text" name="genre" class="form-control">
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary mt-3">追加</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>