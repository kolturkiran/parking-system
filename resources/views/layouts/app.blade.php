<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>parking system</title>
    <script src="https://cdn.tailwindcss.com"></script>    
    <link rel="stylesheet" href="{{ asset('app.css') }}">
</head>
<body>
    <div class="card">
        @if(session()->has('success'))
            <h4 style="color:green">{{session('success')}}</h4>
        @endif        
        <h1 class="card-title">@yield('title')</h1>
        <div>
            @yield('content')
        </div>
    </div>
</body>
</html>