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
    <h1 class="text-center">店舗編集</h1>
    @if(Auth::guard('owner')->check() && Auth::id() === $restaurant->owner_id)
    <a href="{{ route('owner.show', $restaurant) }}" class="text-decoration-none fs-5">&lt; 戻る</a>
    @elseif (Auth::guard('admin')->check())
    <a href="{{ route('admin.show', $restaurant) }}" class="text-decoration-none fs-5">&lt; 戻る</a>
    @endif
    <div class="row row-cols-1 row-cols-md-2 justify-content-center">
        @if(Auth::guard('owner')->check() && Auth::id() === $restaurant->owner_id)
        <form action="{{ route('owner.update', $restaurant) }}" method="post" enctype="multipart/form-data">
        @elseif (Auth::guard('admin')->check())
        <form action="{{ route('admin.update', $restaurant) }}" method="post" enctype="multipart/form-data">
        @endif
            @csrf
            <div class="mb-3 d-flex justify-content-between align-items-center">
                <div class="me-3">
                    <label class="form-label" for="img_path">お店の画像</label>
                    <input id="img_path" class="form-control" type="file" name="img_path" value="{{ $restaurant->img_path }}">
                </div>
                <div style="width: 40%;">
                    <span>現在の画像</span>
                    <img src="{{ asset("/storage/$restaurant->img_path") }}" alt="" style="width: 100%;">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label" for="restaurant_name">店名</label>
                <input class="form-control" type="text" name="restaurant_name" value="{{ $restaurant->restaurant_name }}">
            </div>
            <div class="mb-3">
                <label class="form-label" for="introduction">紹介文</label>
                <textarea class="form-control" name="introduction">{{ $restaurant->introduction }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label" for="genre">料理ジャンル</label>
                <select name="genre" id="genre" class="form-select mb-3">
                    <option disabled selected value>選択してください</option>
                    @if ($errors->any())
                        @foreach($genres as $genre)
                            @if($genre->genre === old('genre'))
                            <option value="{{ $genre->genre }}" selected>{{ $genre->genre }}</option>
                            @else
                            <option value="{{ $genre->genre }}">{{ $genre->genre }}</option>
                            @endif
                        @endforeach
                    @else
                        @foreach($genres as $genre)
                            @if($restaurant->genre === $genre->genre)
                            <option value="{{ $genre->genre }}" selected>{{ $genre->genre }}</option>
                            @else
                            <option value="{{ $genre->genre }}">{{ $genre->genre }}</option>
                            @endif
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label" for="budget">価格帯</label>
                <input class="form-control" type="text" name="budget" value="{{ $restaurant->budget }}">
            </div>
            <div class="mb-3">
                <label class="form-label" for="phone">電話番号</label>
                <input class="form-control" type="text" name="phone" value="{{ $restaurant->phone }}">
        </div>
        <div class="mb-3">
                <label class="form-label" for="address">住所</label>
                <input class="form-control" type="text" name="address" value="{{ $restaurant->address }}">
            </div>
            <div class="mb-3">
                <label class="form-label" for="access">アクセス</label>
                <input class="form-control" type="text" name="access" value="{{ $restaurant->access }}">
            </div>
                <button type="submit" class="btn btn-primary">更新</button>
        </form>
    </div>
@endsection