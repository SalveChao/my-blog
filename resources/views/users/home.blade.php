@extends('layouts.app2')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    ログインしました。<br>
                    <ul>
                        <li><a href="">お気に入り記事</a></li>
                        <li><a href="#">お気に入りユーザー</a></li>
                        <li><a href="#">ログアウト</a></li>
                    </ul>
                    <favorite-component></favorite-component>
                    <example-component></example-component>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
