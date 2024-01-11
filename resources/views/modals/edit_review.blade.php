<div class="modal fade" id="editReviewModal{{ $review->id }}" tabindex="-1" aria-labeledby="editReviewModalLabel{{ $review->id }}"> 
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editReviewModalLabel{{ $review->id }}">レビュー編集</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="閉じる"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('update-review', [$review, $restaurant]) }}" method="post">
                    @csrf
                    <label class="form-label" for="score">満足度</label>
                    <select name="score" id="score" class="form-select mb-3">
                        <option disabled selected value>選択してください</option>
                        @for($i = 5; $i >= 1; $i--)
                            @php
                                $text = '';
                                if($i === 5){
                                    $text = 'とても満足';
                                } elseif($i === 4) {
                                    $text = '満足';
                                } elseif($i === 3) {
                                    $text = '普通';
                                } elseif($i === 2) {
                                    $text = '不満';
                                } elseif($i === 1) {
                                    $text = 'とても不満';
                                }
                            @endphp

                            @if($i === $review->score)
                                <option value="{{ $i }}" selected>{{ $i }}&emsp;{{ $text }}</option>
                            @else
                                <option value="{{ $i }}">{{ $i }}&emsp;{{ $text }}</option>
                            @endif
                        @endfor
                    </select>
                    <label class="form-label" for="content">レビュー</label>
                    <textarea name="content" id="content" class="form-control mb-3">{{ $review->content }}</textarea>
                    <div class="text-end">
                    <button type="submit" class="btn btn-primary">更新</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>