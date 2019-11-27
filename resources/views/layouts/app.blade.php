<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- <title>{{ config('app.name', 'Laravel') }}</title> -->
    @yield('title')

    <!-- Fonts -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" /> -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    @yield('css')
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">

</head>
<body>
    <div id="app">
        @include('partials.nav')

        <main class="py-3">
            <div class="container-fluid">
                @if(session()->has('error'))
              　<div class="alert alert-success">
                    {{ session()->get('error') }}
              　</div>
                @endif
            	@auth
				<div class="container-fluid">
				@if(session()->has('success'))
            	<div class="alert alert-success">
            	  	{{ session()->get('success') }}
        	  　</div>
        	  　@endif
				<div class="row">
    	          	<div class="col-sm-3">
                        <a href="{{ route('posts.index') }}">ブログの表示</a>
                        <!-- @yield('editforposts') -->
                        <table class="table table-sm">
    	          		    <tr><td></td></tr>
                            <tr><td><a href="{{ route('manage-posts.allposts') }}">投稿管理</a></td></tr>
                            <tr><td><a href="{{ route('categories.index') }}">カテゴリ</a></td></tr>
                            <tr>
                                <td><a href="{{ route('users.index') }}">ユーザー</a></td>
                            </tr>
                            <tr>

                                <td><a href="{{ route('comments.index') }}">コメント</a></td>
                                
                            </tr>
                            <tr><td><a href="{{ route('trashed-posts') }}" class="list-group mt-5">ゴミ箱</a></td></tr>
                        </table>
    	           　</div>
		           　<div class="col-sm-8 col-sm-offset-1">
		               	@yield('content')
	                    @yield('comments')
	          	     </div>
          　     </div>
            </div>
                @else
       	 	      @yield('content')
                @endauth
        </main>
    </div>
    <!-- Scripts -->
    <script defer src="https://use.fontawesome.com/releases/v5.7.2/js/all.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>

</body>
@yield('scripts')
</body>
</html>
