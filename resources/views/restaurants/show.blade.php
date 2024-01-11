@extends('layouts.app')

@section('content')
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    @if (session('flash_message'))
        <p class="text-success fs-5 text-center">{{ session('flash_message') }}</p>
    @endif
    <div class="d-flex justify-content-between mb-3">
        @if(preg_match('/mypage/', url()->previous()))
            @if(Request::is('owner*'))
                @if(preg_match('/keyword/', url()->previous()))
                    <a href="{{ url()->previous() }}" class="text-decoration-none fs-5">&lt; 戻る</a>
                @else
                    <a href="{{ route('owner.mypage') }}" class="text-decoration-none fs-5">&lt; 戻る</a>
                @endif
            @elseif(Request::is('user*'))
                @if(preg_match('/keyword/', url()->previous()))
                    <a href="{{ url()->previous() }}" class="text-decoration-none fs-5">&lt; 戻る</a>
                @else
                    <a href="{{ route('user.mypage') }}" class="text-decoration-none fs-5">&lt; 戻る</a>
                @endif
            @endif
        @elseif(preg_match('/edit/', url()->previous()) && Auth::guard('owner')->check())
            @if(Request::is('owner*'))
            <a href="{{ route('owner.mypage') }}" class="text-decoration-none fs-5">&lt; 戻る</a>
            @endif
        @elseif(preg_match('/keyword/', url()->previous()))
            <a href="{{ url()->previous() }}" class="text-decoration-none fs-5">&lt; 戻る</a>
        @else
            @if(Request::is('owner*'))
            <a href="{{ url('/owner') }}" class="text-decoration-none fs-5">&lt; 戻る</a>
            @elseif(Request::is('admin*'))
            <a href="{{ url('/admin') }}" class="text-decoration-none fs-5">&lt; 戻る</a>
            @elseif(Request::is('user*'))
            <a href="{{ url('/user') }}" class="text-decoration-none fs-5">&lt; 戻る</a>
            @else
            <a href="{{ url('/') }}" class="text-decoration-none fs-5">&lt; 戻る</a>
            @endif
        @endif
        <div>
            @if(Auth::guard('web')->check())
                <form action="{{ route('user.bookmark', $restaurant) }}" method="post">
                @csrf
                @if(!Auth::user()->restaurants()->where('restaurant_id', $restaurant->id)->exists())
                    <button type="submit" class="btn btn-success mb-2">お気に入り</button>
                @elseif(Auth::user()->restaurants()->where('restaurant_id', $restaurant->id)->exists())
                    <button type="submit" class="btn btn-secondary mb-2">お気に入り解除</button>
                @endif
                </form>
            @endif
            @if(Auth::guard('owner')->check() && Auth::id() === $restaurant->owner_id)
            <button class="btn btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#createMenuModal">メニュー追加</button>
            <a href="{{ route('owner.edit', $restaurant) }}" class="btn btn-primary me-2">編集</a>
            <a href="#" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">削除</a>
            @include('modals.create_menu')
            @include('modals.delete_restaurant')
            @elseif(Auth::guard('admin')->check())
            <button class="btn btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#createMenuModal">メニュー追加</button>
            <a href="{{ route('admin.edit', $restaurant) }}" class="btn btn-primary me-2">編集</a>
            <a href="#" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">削除</a>
            @include('modals.create_menu')
            @include('modals.delete_restaurant')
            @elseif(Auth::guard('web')->check())
            <a href="#" class="btn btn-primary me-3" data-bs-toggle="modal" data-bs-target="#reviewCreateModal">レビュー投稿</a>
            @include('modals.review_create')
            @endif
        </div>
    </div>
    <h2 class="text-center mb-3">店舗情報</h2>
    <div class="row justify-content-center mb-3">
        <div class="col-12 col-md-10">
            <div class="card">
                <img src="{{ asset("/storage/$restaurant->img_path") }}" class="card-img-top" alt="..." style="height:380px;">
                <div class="card-body">
                    <p class="card-text fs-5">{{ $restaurant->genre }}</p>
                    <h5 class="card-title fs-1">{{ $restaurant->restaurant_name }}</h5>
                    <p class="card-text fs-5">{{ $restaurant->introduction }}</p>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">価格帯&emsp;{{ $restaurant->budget }}</li>
                    <li class="list-group-item">
                        <details>
                            <summary>メニュー一覧</summary>
                            @foreach($menus as $menu)
                            @include('modals.edit_menu')
                            @include('modals.delete_menu')
                            <div>
                                <div class="fs-5">{{ $menu->menu_name }}:{{ $menu->price }}</div>
                                @if(Auth::guard('owner')->check() && Auth::id() === $restaurant->owner_id || Auth::guard('admin')->check())
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editMenuModal{{ $menu->id }}">編集</button>
                                <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteMenuModal{{ $menu->id }}">削除</button>
                                @endif
                            </div>
                            @endforeach
                        </details>
                    </li>
                    <li class="list-group-item">電話番号&emsp;{{ $restaurant->phone }}</li>
                    <li class="list-group-item">住所&emsp;{{ $restaurant->address }}</li>
                    <li class="list-group-item">アクセス&emsp;{{ $restaurant->access }}</li>
                </ul>
            </div>
        </div>
    </div>
    @if(count($restaurant->reviews) !== 0)
    <h2 class="text-center mb-3">レビュー一覧</h2>
    @endif
    <div class="row g-4">
        @foreach($restaurant->reviews as $review)

        @include('modals.edit_review')
        @include('modals.delete_review')

        <div class="col-12">
            <div class="card bg-light">
                <div class="card mx-2 my-2">
                    <div class="card-body">
                        <h6 class="card-subtitle text-muted">{{ $review->created_at }}</h6>
                        <div class="card-title mb-0">{{ $review->user->name }}</div>
                        <div class="d-flex">
                            @for($i = 1; $i <= $review->score; $i++)
                            <img src="{{ asset('storage/img/star-point.png') }}" alt="" style="width:16px;">
                            @endfor
                            @for($i = 1; $i <= 5 - $review->score; $i++)
                            <img src="{{ asset('storage/img/star-no-point.png') }}" alt="" style="width:16px;">
                            @endfor
                        </div>
                        <p class="card-text">{{ $review->content }}</p>
                    </div>
                </div>
                @if(Auth::guard('web')->check() && Auth::id() === $review->user_id || Auth::guard('admin')->check())
                <div class="text-end">
                    <button class="btn btn-primary mb-2 mx-2" data-bs-toggle="modal" data-bs-target="#editReviewModal{{ $review->id }}">編集</button>
                    <button class="btn btn-danger mb-2 mx-2" data-bs-toggle="modal" data-bs-target="#deleteReviewModal{{ $review->id }}">削除</button>   
                </div>
                @endif
            </div>
        </div>
        @endforeach
    </div>
@endsection