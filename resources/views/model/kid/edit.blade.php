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

            <div class="card">
                <div class="card-header">Consultar Alunos</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.kid.update',['aluno'=>$model->id]) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group row">

                            <div class="col-md-6">
                                <label for="name" class="">{{ __('Nome') }}</label>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $model->name }}" required autocomplete="name" autofocus>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                <label for="identification" class="">{{ __('RM') }}</label>
                                <input id="identification" type="identification" class="form-control @error('identification') is-invalid @enderror" name="identification" value="{{ $model->identification }}" required autocomplete="identification">

                                @error('identification')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="id_kid_class" class="">{{ __('Classe') }}</label>
                                <select id="id_kid_class" type="id_kid_class" class="form-control">
                                    @if(!empty($modelKidClass))
                                    @foreach($modelKidClass as $kidClass)
                                    <option @if($kidClass->time == "Tarde") selected @endif value="{{ $kidClass->id }}">{{ $kidClass->name }}</option>
                                    @endforeach
                                    @endif
                                </select>
                                @error('id_kid_class')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="responsable1_name" class="">{{ __('Responsável') }}</label>
                                <input id="responsable1_name" type="text" class="form-control @error('responsable1_name') is-invalid @enderror" name="responsable1_name" value="{{ $model->responsable1_name }}" required autocomplete="responsable1_name" autofocus>

                                @error('responsable1_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="responsable1_phone" class="">{{ __('Telefone') }}</label>
                                <input id="responsable1_phone" type="responsable1_phone" class="form-control @error('responsable1_phone') is-invalid @enderror" name="responsable1_phone" value="{{ $model->responsable1_phone }}" required autocomplete="responsable1_phone">

                                @error('responsable1_phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="responsable2_name" class="">{{ __('Responsável') }}</label>
                                <input id="responsable2_name" type="text" class="form-control @error('responsable2_name') is-invalid @enderror" name="responsable2_name" value="{{ $model->responsable2_name }}" required autocomplete="responsable2_name" autofocus>

                                @error('responsable2_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="responsable2_phone" class="">{{ __('Telefone') }}</label>
                                <input id="responsable2_phone" type="responsable2_phone" class="form-control @error('responsable2_phone') is-invalid @enderror" name="responsable2_phone" value="{{ $model->responsable2_phone }}" required autocomplete="responsable2_phone">

                                @error('responsable2_phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6 center-align">
                                <img src="{{ $model->photo() }}" height="140" width="140" class="align-self-start mr-3 rounded-circle" alt="...">
                                <input type="file" class="form-control-file" id="photo" name="photo" />
                            </div>
                        </div>

                        <div>
                            <hr>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-success">
                                    {{ __('Atualizar') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>


            <div class="card list-group my-5">
                <div class="card-header">Cadastro</div>
                <a data-toggle="modal" data-target="#kid{{$model->id}}" class="card-header bg-white list-group-item list-group-item-action">
                    <div class="row d-flex align-items-center  py-1">
                        <div class="col-12 col-sm-12 col-md-4 text-truncate">
                            <img src="{{ $model->photo() }}" height="38" width="24" class="align-self-start mr-3 rounded-circle" alt="...">
                            {{$model->name}}
                        </div>
                        <div class="d-none d-md-block col-md-4 text-center text-truncate">
                            {{$model->class->name}}
                        </div>
                        <div class="d-none d-md-block col-md-2 text-center text-truncate">
                            {{$model->class->time}}
                        </div>
                        <div class="d-none d-md-block col-md-2 text-right text-truncate">
                            {{$model->identification}}
                        </div>
                    </div>
                </a>
                <div class="modal fade" id="kid{{$model->id}}" tabindex="-1" role="dialog" aria-labelledby="kid{{$model->id}}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="d-flex justify-content-center mb-3">
                                    <img src="{{ $model->photo() }}" height="140" width="140" class="align-self-start mr-3 rounded-circle" alt="...">
                                </div>
                                <h6>
                                    Olá <strong>{{ Auth::user()->name }}!</strong> meu nome é <strong>{{ $model->name}}</strong> e meu RM é <strong>{{ $model->identification}}</strong>.
                                </h6>
                                <p class="alert alert-success text-justify">
                                    Eu estudo na turma <strong>{{ $model->class->name}}</strong> no período da <strong>{{ $model->class->time}}</strong>, para minha segurança apenas <strong>{{ $model->responsable1_name}}</strong> e <strong>{{ $model->responsable2_name}}</strong> podem me levar. Se houver qualquer problema ligue para <strong>{{ $model->responsable1_phone}}</strong> ou <strong>{{ $model->responsable2_phone}}</strong>, até mais!!!
                                </p>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <a class="btn btn-lg btn-success" href="whatsapp://send?abid=+55{{$model->responsable1_phone}}&text=" Oi {{$model->responsable1_name}}!! precisamos falar sobre a(o) {{ $model->name}}"> Whatsapp {{$model->responsable1_name}}</a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
