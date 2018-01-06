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
                                        <dd>{{ $client->nom_entreprise }}</dd>
                                        <dt>TVA : </dt>
                                        <dd>{{ $client->tva }}</dd>
                                        <dt>Personne de contact : </dt>
                                        <dd>{{ $client->personne_contact }}</dd>
                                        <dt>Téléphone : </dt>
                                        <dd>{{ $client->telephone }}</dd>
                                        <dt>Email : </dt>
                                        <dd>{{ $client->email }}</dd>
                                    </dl>
                                </div>
                                <div class="col-lg-6">
                                    <dl class="dl-horizontal">
                                        <dt>Localité : </dt>
                                        <dd>{{ $client_localite->code_postal }} {{ $client_localite->localite }}</dd>
                                        <dt>Adresse : </dt>
                                        <dd>{{ $client->adresse }}</dd>
                                        <dt>Site internet : </dt>
                                        <dd>{{ $client->site }}</dd>
                                        <dt>Linkedin : </dt>
                                        <dd>{{ $client->linkedin }}</dd>
                                    </dl>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 text-right">
                                    {{Form::open([
                                        'route'=>['missions.create.from.client',$client->id],
                                        'method'=>'GET',
                                        'role'=>'form',
                                        'style' => 'display:inline'
                                    ]) }}

                                    {{ Form::submit('Ajouter une fiche',['class'=>'btn btn-primary'])}}
                                    {{ Form::close() }}

                                    {{Form::open([
                                        'route'=>['clients.edit',$client->id],
                                        'method'=>'GET',
                                        'role'=>'form',
                                        'style' => 'display:inline'
                                    ]) }}

                                    {{ Form::submit('Modifier',['class'=>'btn btn-warning'])}}
                                    {{ Form::close() }}
                        
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
                            <div class="row">
                                <div class="well-lg">
                                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-clients">
                                        <thead>
                                            <tr>
                                                <th>Fiches</th>
                                                <th>Fonction</th>
                                                <th>Date</th>
                                                <th>Remarques</th>
                                                <th>Status</th>
                                                <th>Mail</th>
                                                <th>Supprimer</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($client->missions as $mission)
                                            <tr class="odd">
                                                <td>
                                                    <a href="{{ route('missions.show',$mission->id)}}">
                                                        {{ $mission->id}}
                                                    </a>
                                                </td>
                                                <td>
                                                        {{ $mission->fonction}}
                                                </td>
                                                <td>{{ Carbon::parse($mission->created_at)->format('d-m-Y') }}</td>
                                                <td>
                                                        {{ $mission->remarques}}
                                                </td>
                                                <td>
                                                        {{ $mission->status}}
                                                </td>
                                                <td style="text-align: center">
                                                    <a href="{{ route('clients.show',$client->id)}}">
                                                        <i class="fa fa-envelope-o" aria-hidden="true" title="Afficher les emails"></i>
                                                    </a>
                                                </td>
                                                <td style="text-align: center">
                                                    {{Form::open([
                                                        'route'=>['missions.destroy',$mission->id],
                                                        'method'=>'DELETE',
                                                        'role'=>'form',
                                                        'onsubmit' => 'return confirm("Etes vous sur de vouloir supprimer cette mission")'
                                                    ]) }}
                                                        <button class="fa fa-trash" aria-hidden="true" title="supprimer mission"></button>                                        
                                                    {{ Form::close() }}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="7">Aucune missions.</td></tr>
                                        @endforelse
                                        </tbody>
                                    </table>
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
