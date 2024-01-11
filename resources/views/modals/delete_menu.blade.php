<div class="modal fade" id="deleteMenuModal{{ $menu->id }}" tabindex="-1" aria-labeledby="deleteMenuModalLabel{{ $menu->id }}"> 
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteMenuModalLabel{{ $menu->id }}">メニュー「{{ $menu->menu_name }}:{{ $menu->price }}」を削除してもよろしいですか？</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="閉じる"></button>
            </div>
            <div class="modal-footer">
                <form action="{{ route('menu.delete', $menu) }}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-danger">削除</button>
                </form>
            </div>
        </div>
    </div>
</div>