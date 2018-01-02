@extends('layouts.app')

@section('title',$title)

@section('css')
@endsection

@section('js')
@endsection

@include('includes.sidebar')

@section('content')
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">{{ $title }}</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    {{Form::open([
                                        'route'=>['clients.edit',$client->id],
                                        'method'=>'GET',
                                        'role'=>'form'
                                    ]) }}
                                    <dl class="dl-horizontal">
                                        <dt>Nom entreprise : </dt>
                                        <dd>{{ $client->nom_entreprise}}</dd>
                                        <dt>TVA : </dt>
                                        <dd>{{ $client->tva}}</dd>
                                        <dt>Personne de contact : </dt>
                                        <dd>{{ $client->personne_contact}}</dd>
                                        <dt>Téléphone : </dt>
                                        <dd>{{ $client->telehone}}</dd>
                                        <dt>Email : </dt>
                                        <dd>{{ $client->email}}</dd>
                                    </dl>
                                </div>
                                <div class="col-lg-6">
                                    <dl class="dl-horizontal">
                                        <dt>Localité : </dt>
                                        <dd>{{ $client_localite->localite}}</dd>
                                        <dt>Adresse : </dt>
                                        <dd>{{ $client->adresse}}</dd>
                                        <dt>Site internet : </dt>
                                        <dd>{{ $client->site}}</dd>
                                        <dt>Linkedin : </dt>
                                        <dd>{{ $client->linkedin}}</dd>
                                    </dl>

                                    <div style="margin-top:35px">
                                    {{ Form::submit('Modifier',['class'=>'btn btn-warning pull-right'])}}
                                    </div>

                                    {{Form::close()}}
                                </div>
                            </div>
                           
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
@endsection
