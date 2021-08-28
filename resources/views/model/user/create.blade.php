@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(!empty($message))
            <div class="alert alert-info" role="alert">
                {{ $message}}
            </div>
            @endif

            @if($errors->any())
            <div class="card mb-3">
                <div class="card-header">Erros encontrados</div>
                @foreach ($errors->all() as $error)
                <div class="card-header text-danger bg-white">{{ $error }}</div>
                @endforeach
            </div>
            @endif

            <div class="card">
                <div class="card-header">Consultar Usuários</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.user.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">

                            <div class="col-md-4">
                                <label for="name" class="">{{ __('Nome') }}</label>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label for="email" class="">{{ __('E-Mail') }}</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label for="phone" class="">{{ __('Telefone') }}</label>
                                <input id="phone" autocomplete="phone" type="phone" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="phone">

                                @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                <label for="type" class="">{{ __('Tipo') }}</label>

                                <select id="type" type="type" name="type" class="form-control">
                                    <option>Selecione</option>

                                    @if(Auth()->user()->type == 'admin')
                                    <option value="default">Padrão</option>
                                    <option value="admin">Administrador</option>

                                    @elseif(Auth()->user()->type == 'master')
                                    <option value="default">Padrão</option>
                                    <option value="admin">Administrador</option>
                                    <option value="master">Master</option>
                                    @else
                                    <option value="default">Padrão</option>
                                    @endif

                                </select>
                                @error('type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row">

                            <div class="col-md-4">
                                <label for="password" class="">{{ __('Senha') }}</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="password-confirm" class="">{{ __('Confirmar Senha') }}</label>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                            <div class="col-md-4">
                                <label for="active" class="">{{ __('Situação') }}</label>

                                <select id="active" name="active" class="form-control">
                                    <option>Selecione</option>
                                    <option value="1">Ativo</option>
                                    <option value="0">Inativo</option>
                                </select>
                                @error('active')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>


                        <div>
                            <hr>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-success">
                                    {{ __('Cadastrar') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>


            @if($model != null)
            <div class="card list-group my-5">
                <div class="card-header">Último Cadastrado</div>
                <a data-toggle="modal" data-target="#user{{$model->id}}" class="card-header bg-white list-group-item list-group-item-action">
                    <div class="row d-flex align-items-center  py-1">
                        <div class="col-12 col-sm-12 col-md-8 text-truncate">
                            {{$model->name}}
                        </div>
                        <div class="col-12 col-sm-12 col-md-4 text-truncate">
                            {{$model->email}}
                        </div>
                    </div>
                </a>
                <div class="modal fade" id="user{{$model->id}}" tabindex="-1" role="dialog" aria-labelledby="user{{$model->id}}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body">
                                <h6>
                                    {{$model->name}}
                                </h6>
                                <p class="alert alert-success text-justify">
                                    {{$model->email}}
                                </p>
                                <div class="row">
                                    <div class="col-sm-12">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
