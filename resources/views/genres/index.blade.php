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
    @include('modals.create_genre')
    <div class="d-flex justify-content-between mb-3">
        <a href="{{ url('/admin') }}" class="text-decoration-none fs-5">&lt; 戻る</a>
        <div>
           <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createGenreModal">ジャンル追加</button>
        </div>
    </div>
    <div>
        <h2 class="text-center">ジャンル一覧</h2>
        <div class="row mt-3 mx-auto">
            @foreach($genres as $genre)
                @include('modals.edit_genre')
                @include('modals.delete_genre')
                <div class="col-12 col-md-6 d-flex justify-content-between py-2 border">
                    <div class="fs-4">{{ $genre->genre }}</div>
                    <div>
                        <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#editGenreModal{{ $genre->id }}">編集</button>
                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteGenreModal{{ $genre->id }}">削除</button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection