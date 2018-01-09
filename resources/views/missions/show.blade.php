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
                                        <dt>Nom du client : </dt>
                                        <dd>{{ $client->nom_entreprise }}</dd>
                                        <dt>Fonction : </dt>
                                        <dd>{{ $mission->fonction }}</dd>
                                        <dt>Référence : </dt>
                                        <dd>{{ $mission->id }}</dd>
                                        <dt>Date : </dt>
                                        <dd>{{ Carbon::parse($mission->created_at)->format('d-m-Y') }}</dd>
                                        <dt>Type de contrat : </dt>
                                        <dd>{{ $mission->typeContrat->type }}</dd>
                                    </dl>
                                </div>
                                <div class="col-lg-6">
                                    <dl class="dl-horizontal">
                                        <dt>Status : </dt>
                                        <dd>{{ $mission->status }}</dd>
                                        <dt>Contrat : </dt>
                                        <dd>
                                            @if($mission->contrat_id)
                                               <a href="{{ url(Storage::url($mission->contrat->url_document)) }}" target="_blank"> 
                                                   <i class="fa fa-download" aria-hidden="true"></i>
                                                </a>
                                            @else()
                                                Aucun contrat
                                            @endif
                                        </dd>

                                        <dt>Job description : </dt>
                                        <dd>
                                        @if($mission->job_descriptions)
                                            @foreach($mission->job_descriptions as $job_description)
                                               <a href="{{ url(Storage::url($job_description->url_document)) }}" target="_blank"> 
                                                   <i class="fa fa-download" aria-hidden="true"></i>
                                                   {{ $job_description->description }}
                                                </a></br>
                                            @endforeach
                                        @else()
                                            Aucun job description
                                        @endif
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 text-right">
                                    {{Form::open([
                                        'route'=>['missions.create',$client->id],
                                        'method'=>'GET',
                                        'role'=>'form',
                                        'style' => 'display:inline'
                                    ]) }}

                                    {{ Form::submit('Ajouter un candidat',['class'=>'btn btn-primary'])}}
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
                                        'route'=>['missions.destroy',$mission->id],
                                        'method'=>'DELETE',
                                        'role'=>'form',
                                        'style' => 'display:inline',
                                        'onsubmit' => 'return confirm("Etes vous sur de vouloir supprimer cette mission")'
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
                                                    <a href="{{ route('clients.show',$mission->id)}}">
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
                                                        'route'=>['clients.destroy',$mission->id],
                                                        'method'=>'DELETE',
                                                        'role'=>'form',
                                                        'onsubmit' => 'return confirm("Etes vous sur de vouloir supprimer ce client")'
                                                    ]) }}
                                                        <button class="fa fa-trash" aria-hidden="true" title="supprimer client"></button>                                        
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
