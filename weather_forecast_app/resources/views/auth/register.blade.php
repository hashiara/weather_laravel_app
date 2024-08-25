@extends('layouts.head')
@section('title', '登録画面')
@section('link')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css"/>
<script src="{{ asset('/js/passwordEye.js') }}"></script>
@endsection

@extends('layouts.auth')
@section('form')
<form method="POST" action="{{ route('register.store') }}" class="mx-5 py-4 bg-white border border-secondary-subtle rounded-3">
    @csrf

    <div class="form-content">
        <label for="mail" class="form-label">メールアドレス</label><span class="text-danger fw-bold">*</span>
        <input type="email" id="mail" name="mail" placeholder="info@example.com" class="form-control" value="{{ old('mail') }}" />
        <div class="text-danger">{{ $errors->first('mail') }}</div>
    </div>

    <div class="form-content">
        <label for="user_name" class="form-label">ユーザー名</label><span class="text-danger fw-bold">*</span>
        <input type="text" id="user_name" name="user_name" placeholder="ニックネーム等" class="form-control" value="{{ old('user_name') }}" />
        <div class="text-danger">{{ $errors->first('user_name') }}</div>
    </div>

    <div class="form-content">
        <label for="otk" class="form-label">ワンタイム認証キー</label><span class="text-danger fw-bold">*</span>
        <input type="text" id="otk" name="otk" placeholder="Lineに送信された12桁のキー" class="form-control" value="{{ old('otk') }}" />
        <div class="text-danger">{{ $errors->first('otk') }}</div>
        @if (session('error')) 
            <div class="text-danger">{!! session('error') !!}</div>
        @endif
    </div>

    <div class="form-content">
        <label for="password" class="form-label">新しいパスワード</label><span class="text-danger fw-bold">*</span>
        <div class="position-relative">
            <input type="password" id="password" name="password" placeholder="全角半角英数字(記号は任意)の8～12桁" class="form-control" />
            <i id="eyeIcon" class="bi bi-eye translate-middle position-absolute top-50 end-0"></i>
        </div>
        <div class="text-danger">{{ $errors->first('password') }}</div>
    </div>

    <div class="text-center my-3">
        <button class="btn btn-info text-white" type="submit">登　録</button>
        <a href="{{ route('login.page') }}" class="link-offset-2 link-underline link-underline-opacity-0 d-block mt-3">アカウントをお持ちの方はこちら</a>
    </div>
</form>
@endsection