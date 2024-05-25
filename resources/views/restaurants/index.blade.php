@extends('layouts.app')

@section('content')

@if(Request::is('*mypage*'))
    @if(Auth::guard('owner')->check())
    <a href="{{ route('owner-home') }}" class="text-decoration-none fs-5 d-inline-block mb-3">&lt; HOME</a>
    @elseif(Auth::guard('web')->check())
    <a href="{{ route('user-home') }}" class="text-decoration-none fs-5 d-inline-block mb-3">&lt; HOME</a>
    @endif
@endif
<div class="d-flex flex-wrap">
@if(Auth::guard('owner')->check())
    @if(Request::is('*mypage*'))
    <form action="{{ route('owner.mypage') }}" method="get">
    @else
    <form action="{{ route('owner-home') }}" method="get">
    @endif
@elseif(Auth::guard('admin')->check())
    <form action="{{ route('admin-home') }}" method="get">
@elseif(Auth::guard('web')->check())
    @if(Request::is('*mypage*'))
    <form action="{{ route('user.mypage') }}" method="get">
    @else
    <form action="{{ route('user-home') }}" method="get">
    @endif
@else
    <form action="{{ route('index') }}" method="get">
@endif
    <div class="input-group mb-3">
    @isset($_GET['keyword'])
    <input type="text" class="form-control" placeholder="キーワードを入力" name="keyword" value="{{ $_GET['keyword'] }}">
    @else
    <input type="text" class="form-control" placeholder="キーワードを入力" name="keyword">
    @endisset
    <select class="form-select" name="genre">
    @isset($_GET['genre'])
        @if($_GET['genre'] === "")
            <option value="" selected>ジャンル選択</option>
            @foreach($genres as $genre)
            <option value="{{ $genre->genre }}">{{ $genre->genre }}</option>
            @endforeach
        @else
            <option value="">ジャンル選択</option>
            @foreach($genres as $genre)
                @if($_GET['genre'] === $genre->genre)
                    <option value="{{ $genre->genre }}" selected>{{ $genre->genre }}</option>
                @else
                    <option value="{{ $genre->genre }}">{{ $genre->genre }}</option>
                @endif
            @endforeach
        @endif
    @else
        <option value="" selected>ジャンル選択</option>
        @foreach($genres as $genre)
        <option value="{{ $genre->genre }}">{{ $genre->genre }}</option>
        @endforeach
    @endisset
    </select>
    <button class="btn btn-outline-success me-3" type="submit"><i class="fas fa-search"></i> 検索</button>
    </div>
</form>

<!-- @if(Auth::guard('owner')->check())
    @if(Request::is('*mypage*'))
    <form action="{{ route('owner.mypage') }}" method="get">
    @else
    <form action="{{ route('owner-home') }}" method="get">
    @endif
@elseif(Auth::guard('admin')->check())
    <form action="{{ route('admin-home') }}" method="get">
@elseif(Auth::guard('web')->check())
    @if(Request::is('*mypage*'))
    <form action="{{ route('user.mypage') }}" method="get">
    @else
    <form action="{{ route('user-home') }}" method="get">
    @endif
@else
    <form action="{{ route('index') }}" method="get">
@endif
    <div class="input-group mb-3">
    @isset($_GET['currentLocation'])
    <input type="text" class="form-control" placeholder="現在地を入力" name="currentLocation" value="{{ $_GET['currentLocation'] }}">
    @else
    <input type="text" class="form-control" placeholder="現在地を入力" name="currentLocation">
    @endisset
    <button class="btn btn-outline-success" type="submit"><i class="fas fa-search"></i> 近くのお店を検索</button>
    </div>
</form> -->

@if(Auth::guard('owner')->check())
    @if(Request::is('*mypage*'))
    <a href="{{ route('owner.mypage') }}" class="btn btn-outline-danger mb-3 ms-2">リセット</a>
    @else
    <a href="{{ route('owner-home') }}" class="btn btn-outline-danger mb-3 ms-2">リセット</a>
    @endif
@elseif(Auth::guard('admin')->check())
    <a href="{{ route('admin-home') }}" class="btn btn-outline-danger mb-3 ms-2">リセット</a>
@elseif(Auth::guard('web')->check())
    @if(Request::is('*mypage*'))
    <a href="{{ route('user.mypage') }}" class="btn btn-outline-danger mb-3 ms-2">リセット</a>
    @else
    <a href="{{ route('user-home') }}" class="btn btn-outline-danger mb-3 ms-2">リセット</a>
    @endif
@else
    <a href="{{ route('index') }}" class="btn btn-outline-danger mb-3 ms-2">リセット</a>
@endif
</div>
@if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
    @if(isset($serched_restaurants))
        @foreach($serched_restaurants as $restaurant)
            <div class="col">
                <div class="card mx-auto" style="width: 18rem;">
                @if(Auth::guard('owner')->check())
                    <a href="{{ route('owner.show', $restaurant) }}" class="text-decoration-none" style="color:black;">
                @elseif(Auth::guard('admin')->check())
                    <a href="{{ route('admin.show', $restaurant) }}" class="text-decoration-none" style="color:black;">
                @elseif(Auth::guard('web')->check())
                    <a href="{{ route('user.show', $restaurant) }}" class="text-decoration-none" style="color:black;">
                @else
                    <a href="{{ route('show', $restaurant) }}" class="text-decoration-none" style="color:black;">
                @endif
                        <img src="{{ asset("/storage/$restaurant->img_path") }}" class="card-img-top" alt="..." style="height:180px;">
                        <div class="card-body">
                            <p class="card-text">{{ $restaurant->genre }}</p>
                            <h5 class="card-title">{{ $restaurant->restaurant_name }}</h5>
                            <p class="card-text">{{ $restaurant->access }}</p>
                        </div>
                    </a>
                </div>
            </div>
        @endforeach
    @elseif(isset($near_restaurants))
        @foreach($near_restaurants as $restaurant)
            <div class="col">
                <div class="card mx-auto" style="width: 18rem;">
                @if(Auth::guard('owner')->check())
                    <a href="{{ route('owner.show', $restaurant) }}" class="text-decoration-none" style="color:black;">
                @elseif(Auth::guard('admin')->check())
                    <a href="{{ route('admin.show', $restaurant) }}" class="text-decoration-none" style="color:black;">
                @elseif(Auth::guard('web')->check())
                    <a href="{{ route('user.show', $restaurant) }}" class="text-decoration-none" style="color:black;">
                @else
                    <a href="{{ route('show', $restaurant) }}" class="text-decoration-none" style="color:black;">
                @endif
                        <img src="{{ asset("/storage/$restaurant->img_path") }}" class="card-img-top" alt="..." style="height:180px;">
                        <div class="card-body">
                            <p class="card-text">{{ $restaurant->genre }}</p>
                            <h5 class="card-title">{{ $restaurant->restaurant_name }}</h5>
                            <p class="card-text">{{ $restaurant->access }}</p>
                        </div>
                    </a>
                </div>
            </div>
        @endforeach
    @else
        @foreach($restaurants as $restaurant)
        <div class="col">
            <div class="card mx-auto" style="width: 18rem;">
            @if(Auth::guard('owner')->check())
                <a href="{{ route('owner.show', $restaurant) }}" class="text-decoration-none" style="color:black;">
            @elseif(Auth::guard('admin')->check())
                <a href="{{ route('admin.show', $restaurant) }}" class="text-decoration-none" style="color:black;">
            @elseif(Auth::guard('web')->check())
                <a href="{{ route('user.show', $restaurant) }}" class="text-decoration-none" style="color:black;">
            @else
                <a href="{{ route('show', $restaurant) }}" class="text-decoration-none" style="color:black;">
            @endif
                    <img src="{{ asset("/storage/$restaurant->img_path") }}" class="card-img-top" alt="..." style="height:180px;">
                    <div class="card-body">
                        <p class="card-text">{{ $restaurant->genre }}</p>
                        <h5 class="card-title">{{ $restaurant->restaurant_name }}</h5>
                        <p class="card-text">{{ $restaurant->access }}</p>
                    </div>
                </a>
            </div>
        </div>
        @endforeach
    @endif
    
</div>
@endsection