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
                <div class="card-header">Consultar Alunos</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.kid.class.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">

                            <div class="col-md-8">
                                <label for="name" class="">{{ __('Nome') }}</label>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="time" class="">{{ __('Turno') }}</label>
                                <select id="time" name="time" class="form-control">
                                    <option selected value="Manhã">Manhã</option>
                                    <option value="Tarde">Tarde</option>
                                </select>
                                @error('time')
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
                <a data-toggle="modal" data-target="#kid{{$model->id}}" class="card-header bg-white list-group-item list-group-item-action">
                    <div class="row d-flex align-items-center  py-1">
                        <div class="col-12 col-sm-12 col-md-8 text-truncate">
                            {{$model->name}}
                        </div>
                        <div class="col-12 col-sm-12 col-md-4 text-truncate">
                            {{$model->time}}
                        </div>
                    </div>
                </a>
                <div class="modal fade" id="kid{{$model->id}}" tabindex="-1" role="dialog" aria-labelledby="kid{{$model->id}}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body">
                                <h6>
                                    {{$model->name}}
                                </h6>
                                <p class="alert alert-success text-justify">
                                    {{$model->time}}
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
