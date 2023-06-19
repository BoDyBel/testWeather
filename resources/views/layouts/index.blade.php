<!doctype html>
<html lang="ru" >
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Погода</title>
    @vite(['resources/js/app.js'])
    <meta name="theme-color" content="#7952b3">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Custom styles for this template -->
    <link href="pricing.css" rel="stylesheet">
</head>
<body class="bg-info">
<div class="container py-3">
    <header>
        @if(session('message'))
            <div class="alert alert-danger">{{session('message') }}</div>
        @endif
        <div class="d-flex flex-column flex-md-row align-items-center pb-3 mb-1">
            <a href="/" class="d-flex align-items-center text-dark text-decoration-none text-white">
               <span class="fs-4">{{!isset($cityName) ? $weather['cityName'] : $cityName}}</span>
            </a>
        </div>
        <div class="d-flex flex-column flex-md-row align-items-center pb-3">
            <a href="/" class="d-flex align-items-center text-dark text-decoration-none text-white me-5"
               data-bs-toggle="modal" data-bs-target="#exampleModal"
            >
               <span class="fs-4">Сменить город</span>
            </a>
            <img src="{{asset('images/location.png')}}" class="w-3">
            <a href="{{route('index')}}" class="d-flex align-items-center text-dark text-decoration-none text-white">
                <span class="fs-4">Мое местоположение</span>
            </a>
        </div>
        <div class="form-check form-switch">
            <form action="{{route('checkbox')}}" method="post" id="checkbox">
                @csrf
                <input class="form-check-input"
                    @isset($checked)
                        checked
                @endisset
                        type="checkbox"  name="checkbox" onchange="document.getElementById('checkbox').submit(); return false;">
                <label class="form-check-label text-white" for="checkbox">Гра́дус Фаренге́йта</label>
            </form>
        </div>
    </header>
    <main class="mx-auto">
        <div class="row mb-3 text-center">

            <div class="col">
                <div class="mb-4 bg-info text-white h-50">
                    <div class="card-body">
                        <img src="{{$weather['icon']}}" class="w-15" >
                        <h2>{{$weather['temp']}}
                            @if(isset($checked))
                                °F
                            @else
                                °
                            @endif
                        </h2>
                        <h2>{{$weather['description']}}</h2>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="pt-4 my-md-5 pt-md-5">
        <div class="row">
            <div class="col-6 col-md text-white text-center">
                <h3>Облачность</h3>
                <ul class="list-unstyled text-small">
                    <li class="mb-1">{{$weather['clouds']}} %</li>
                </ul>
            </div>
            <div class="col-6 col-md text-white text-center">
                <h3>Атмосферное давление</h3>
                <ul class="list-unstyled text-small">
                    <li class="mb-1">{{$weather['pressure']}} гПа</li>
                </ul>
            </div>
            <div class="col-6 col-md text-white text-center">
                <h3>Влажность</h3>
                <ul class="list-unstyled text-small">
                    <li class="mb-1">{{$weather['humidity']}} %</li>
                </ul>
            </div>
            <div class="col-6 col-md text-white text-center">
                <h3>Скорость ветра</h3>
                <ul class="list-unstyled text-small">
                    <li class="mb-1">{{$weather['wind_speed']}} метр/сек</li>
                </ul>
            </div>
        </div>
    </footer>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
            </div>
            <form action="{{route('locationName')}}" method="post">
                @csrf
                <div class="modal-body">
                    <label for="validationServer03" class="form-label">Город</label>
                    <input type="text" name="cityName" class="form-control" id="validationServer01" required>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">ОК</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="javascript">
</script>
</body>
</html>
