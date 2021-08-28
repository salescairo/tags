@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card list-group">
                <div class="card-header">Consultar Turmas</div>
                @foreach($models as $model)
                <a data-toggle="modal" data-target="#kid{{$model->id}}" class="card-header bg-white list-group-item list-group-item-action">
                    <div class="row d-flex align-items-center  py-1">
                        <div class="col-12 col-sm-12 col-md-4 text-truncate">
                            {{$model->name}}
                        </div>
                        <div class="col-12 col-sm-12 col-md-4 text-truncate">
                            {{$model->email}}
                        </div>
                        <div class="col-12 col-sm-12 col-md-2 text-truncate">
                            {{$model->type}}
                        </div>
                        <div class="col-12 col-sm-12 col-md-2 text-truncate text-right @if($model->active == true) black-text @else red-text @endif ">
                            {{ ($model->active == true ? "Ativo" : "Inativo") }}
                        </div>
                    </div>
                </a>
                <div class="modal fade" id="kid{{$model->id}}" tabindex="-1" role="dialog" aria-labelledby="kid{{$model->id}}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body">
                                <h6>
                                    {{$model->name}} {{ $model->type }}
                                </h6>
                                <p class="alert alert-success text-justify">
                                    {{$model->email}}
                                </p>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <form action="{{ route('admin.user.destroy',$model->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-lg btn-danger">APAGAR</button>
                                            <a href="{{ route('admin.user.edit',$model->id) }}" class="btn btn-lg btn-secondary">EDITAR</a>
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
