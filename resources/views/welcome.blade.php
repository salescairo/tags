<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kids Tags</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

</head>

<body class="antialiased">
    <div class="container py-3">
        <div class="jumbotron">
            <h1 class="display-4">Kids Tags!</h1>
            <p class="lead">Ficha de cadastramento de alunos e emissão de carteirinha se etiquetas.</p>
            <hr class="my-4">
            <p>Cadastre alunos, professores, escolas e crie etiquetas</p>
            <a class="btn btn-success btn-lg" href="{{ route('login') }}" role="button">ENTRAR</a>
        </div>

    </div>
</body>

</html>
