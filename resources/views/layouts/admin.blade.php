<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Tag Kids') }}</title>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-light shadow-sm">
            <div class="container d-flex d-flex justify-content-start w-100">
                <ul class="navbar-nav ">
                    <li class="nav-item  dropdown">
                        <a class="nav-link d-flex flex-column justify-content-center" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <div class="d-flex justify-content-center">
                                <img src="https://img.icons8.com/doodle/48/000000/girl.png" />
                            </div>
                            <span class="">Alunos</span>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="{{ route('admin.kid.create') }}">Adicionar</a>
                            <a class="dropdown-item" href="{{ route('admin.kid.index') }}">Listar</a>
                            <a class="dropdown-item" target="_blank" href="{{ route('admin.kid.tag') }}">Gerar Etiqueta</a>
                            <a class="dropdown-item" href="">Exportar</a>
                        </div>
                    </li>
                    <li class="nav-item  dropdown">
                        <a class="nav-link d-flex flex-column justify-content-center" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <div class="d-flex justify-content-center">
                                <img src="https://img.icons8.com/plasticine/100/000000/mommy-and-me-classes.png" />
                            </div>
                            <span class="">Turmas</span>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="{{ route('admin.kid.class.create') }}">Adicionar</a>
                            <a class="dropdown-item" href="{{ route('admin.kid.class.index') }}">Listar</a>
                        </div>
                    </li>
                    @auth
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link  d-flex flex-column justify-content-center" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            <div class="d-flex justify-content-center">
                                <img src="https://img.icons8.com/doodle/48/000000/test-account.png" />
                            </div>
                            <span class=" text-truncate">Minha Conta</span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a href="" class="dropdown-item">Novo Usuário</a>
                            <a href="" class="dropdown-item">Contas de Usuários</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                    @endauth
                </ul>

            </div>
        </nav>

        <main class="py-4 container">
            <div class="row">
                <div class="col-sm-12">
                    @yield('content')
                </div>
            </div>
        </main>
    </div>
</body>

</html>
