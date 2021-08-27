@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card list-group">
                <div class="card-header">Consultar Alunos</div>
                @foreach($models as $model)
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
                                        <form action="{{ route('admin.kid.destroy',$model->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-lg btn-danger">APAGAR</button>
                                            <a href="{{ route('admin.kid.edit',$model->id) }}" class="btn btn-lg btn-secondary">EDITAR</a>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
