@extends('layouts.app')

@section('content')
<div class="">
    <div class="row justify-content-center">
        <div class="col-sm-12">
            <div class="">

                <div class="">
                    <div class="jumbotron">
                        <h1 class="display-4">Tags</h1>
                        <p class="lead">Plataforma de cadastramento de alunos e geração de etiquetas e carteirinhas estudantil.</p>
                        <hr class="my-4">
                        <p>Gerencie Escolas, Professores, Alunos e Etiquetas.</p>
                    </div>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <div class="col-sm-12 col-md-6">
                                <label for="email" class="">E-Mail</label>
                                <input id="email" type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" name="email" value="" required autocomplete="email" autofocus>

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <label for="password" class="">Senha</label>
                                <input id="password" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" value="">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row mb-0">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-lg btn-success">
                                    {{ __('ENTRAR') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
