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
    <h1 class="text-center">店舗登録</h1>
    <a href="{{ route('owner.mypage') }}" class="text-decoration-none fs-5">&lt; 戻る</a>
    <div class="row row-cols-1 row-cols-md-2 justify-content-center">
        <form action="{{ route('owner.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label" for="img_path">お店の画像</label>
                <input id="img_path" class="form-control" type="file" name="img_path" value="{{ old('img_path') }}">
            </div>
            <div class="mb-3">
                <label class="form-label" for="restaurant_name">店名</label>
                <input class="form-control" type="text" name="restaurant_name" value="{{ old('restaurant_name') }}">
            </div>
            <div class="mb-3">
                <label class="form-label" for="introduction">紹介文</label>
                <textarea class="form-control" name="introduction">{{ old('introduction') }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label" for="genre">料理ジャンル</label>
                <select name="genre" id="genre" class="form-select mb-3">
                    <option disabled selected value>選択してください</option>
                    @if ($errors->any())
                        @foreach($genres as $genre)
                            @if($genre->genre === old('genre'))
                            <option value="{{ old('genre') }}" selected>{{ old('genre') }}</option>
                            @else
                            <option value="{{ $genre->genre }}">{{ $genre->genre }}</option>
                            @endif
                        @endforeach
                    @else
                        @foreach($genres as $genre)
                        <option value="{{ $genre->genre }}">{{ $genre->genre }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label" for="budget">価格帯</label>
                <input class="form-control" type="text" name="budget" value="{{ old('budget') }}">
            </div>
            <div class="mb-3">
                <label class="form-label" for="phone">電話番号</label>
                <input class="form-control" type="text" name="phone" value="{{ old('phone') }}">
        </div>
        <div class="mb-3">
                <label class="form-label" for="address">住所</label>
                <input class="form-control" type="text" name="address" value="{{ old('address') }}">
            </div>
            <div class="mb-3">
                <label class="form-label" for="access">アクセス</label>
                <input class="form-control" type="text" name="access" value="{{ old('access') }}">
            </div>
                <button type="submit" class="btn btn-primary">登録</button>
        </form>
    </div>
@endsection