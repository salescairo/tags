@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Dashboard</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="">
                                <h1>
                                    <b>
                                        {{ $kidsAllNumber }}
                                    </b>
                                </h1>
                                alunos cadastrados
                                <hr>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <div class="">
                                {!! $kidsPieChart->container() !!}
                            </div>

                            <script src="{{ $kidsPieChart->cdn() }}"></script>

                            {{ $kidsPieChart->script() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
