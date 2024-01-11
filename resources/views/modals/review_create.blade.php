<div class="modal fade" id="reviewCreateModal" tabindex="-1" aria-labeledby="reviewCreateModalLabel"> 
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reviewCreateModalLabel">レビュー投稿</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="閉じる"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('user.create-review', $restaurant) }}" method="post">
                    @csrf
                    <label class="form-label" for="score">満足度</label>
                    <select name="score" id="score" class="form-select mb-3">
                        <option disabled selected value>選択してください</option>
                        <option value="5">5&emsp;とても満足</option>
                        <option value="4">4&emsp;満足</option>
                        <option value="3">3&emsp;普通</option>
                        <option value="2">2&emsp;不満</option>
                        <option value="1">1&emsp;とても不満</option>
                    </select>
                    <label class="form-label" for="content">レビュー</label>
                    <textarea name="content" id="content" class="form-control mb-3"></textarea>
                    <div class="text-end">
                    <button type="submit" class="btn btn-primary">投稿</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>