@extends('admin.layout')

{{-- メインコンテンツ --}}
@section('contets')
        <h1>管理画面 ログイン</h1>
        <form action="/admin/login" method="post">
            ログインID：<input name="login_id"><br>
            パスワード：<input  name="password" type="password"><br>
            <button>ログインする</button>
        </form>
@endsection