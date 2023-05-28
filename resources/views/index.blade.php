@extends('layout')

{{-- メインコンテンツ --}}
@section('contents')
        <h1>ログイン</h1>
        @if (session('user_registered'))
                ユーザーを登録しました！！<br>
        @endif
        @if ($errors->any())
            <div>
            @foreach ($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
            </div>
        @endif
        <form action="/login" method="post">
            @csrf
            email：<input name="email" value="{{ old('email') }}"><br>
            パスワード：<input  name="password" type="password"><br>
            <button>ログインする</button><br>
            <a href="/user/register">会員登録</a>
        </form>
@endsection
