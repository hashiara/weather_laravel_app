@extends('layouts.head')
@section('title', 'Daily Smart')
@section('link')
<link rel="stylesheet" href="{{ asset('/css/addData.css') }}">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="{{ asset('/js/hamburger.js') }}"></script>
<script src="{{ asset('/js/formSubmit.js') }}"></script>
<script src="{{ asset('/js/select.js') }}"></script>
@endsection

@extends('layouts.main.body')

@if($title === 'weather')
    @section('headerTitle')
        <h1 class="col">天気予報</h1>
    @endsection
@elseif($title === 'horoscope')
    @section('headerTitle')
        <h1 class="col">星占い</h1>
    @endsection
@elseif($title === 'trainStatus')
    @section('headerTitle')
        <h1 class="col">路線情報</h1>
    @endsection
@else
    @section('headerTitle')
        <h1 class="col">タイトルなし</h1>
    @endsection
@endif

@section('content')
    <div class="container position-relative z-1">
        <h2 class="text-light">{{ $user->user_name }}さん</h2>
        <form class="form-content" method="POST" action="{{ route('addData.update', ['title' => $title]) }}" >
            @csrf
            @method('patch')
            
            @if($title === 'weather')
                @include('layouts.main.weatherForm')
            @elseif($title === 'horoscope')
                @include('layouts.main.horoscopeForm')
            @elseif($title === 'trainStatus')
                @include('layouts.main.trainStatusForm')
            @else
                @include('layouts.main.weatherForm')
            @endif

            <div class="text-center my-5">
                <button class="btn btn-info text-white" type="submit">登　録</button>
            </div>

            @if (session('success'))
                <div class="text-center text-light">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->has('message'))
                <div class="text-center text-danger">
                    {{ $errors->first('message') }}
                </div>
            @endif

        </form>
    </div>

    <div class="modal fade" id="deleteAcountModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">アカウント削除</h4>
                </div>
                <div class="modal-body">
                    <label>アカウントが削除されますが本当によろしいですか？</label>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
                    <button id="delete_account_btn" type="button" class="btn btn-danger">削除</button>
                </div>
            </div>
        </div>
    </div>
@endsection