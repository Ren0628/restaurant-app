<div class="modal fade" id="editMenuModal{{ $menu->id }}" tabindex="-1" aria-labeledby="editMenuModalLabel{{ $menu->id }}"> 
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editMenuModalLabel{{ $menu->id }}">メニュー追加</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="閉じる"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('menu.update', $menu) }}" method="post">
                    @csrf
                    <label for="menu_name" class="form-label">メニュー名</label>
                    <input type="text" name="menu_name" class="form-control mb-2" value="{{ $menu->menu_name }}">
                    <label for="price" class="form-label">値段</label>
                    <input type="text" name="price" class="form-control" value="{{ $menu->price }}">
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary mt-3">更新</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>