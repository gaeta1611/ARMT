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
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 text-right">
                                    {{Form::open([
                                        'route'=>['clients.edit',$client->id],
                                        'method'=>'GET',
                                        'role'=>'form',
                                        'style' => 'display:inline'
                                    ]) }}

                                    {{ Form::submit('Modifier',['class'=>'btn btn-warning'])}}
                                    {{Form::close()}}
                        
                                    {{Form::open([
                                        'route'=>['clients.destroy',$client->id],
                                        'method'=>'DELETE',
                                        'role'=>'form',
                                        'style' => 'display:inline',
                                        'onsubmit' => 'return confirm("Etes vous sur de vouloir supprimer ce client")'
                                    ]) }}
                                    
                                    {{ Form::submit('Supprimer',['class'=>'btn btn-danger'])}}
                                    {{ Form::close() }}
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
