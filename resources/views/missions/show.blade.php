@extends('layouts.app')

@section('title',$title)

@section('css')
<!-- DataTables CSS -->
<link href="{{ asset ('../vendor/datatables-plugins/dataTables.bootstrap.css') }}" rel="stylesheet">

<!-- DataTables Responsive CSS -->
<link href="{{ asset('../vendor/datatables-responsive/dataTables.responsive.css') }}" rel="stylesheet">
@endsection

@section('js')
<!-- DataTables JavaScript -->
<script src="{{ asset('../vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('../vendor/datatables-plugins/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('../vendor/datatables-responsive/dataTables.responsive.js') }}"></script>

<script>

$(document).ready(function() {
    $('#dataTables-candidats').DataTable({
        responsive: true,
        order: [[0,'Candidats']]
    });
});
</script>
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
                                        <dd>
                                            <a href="{{ route('clients.show',$mission->client_id) }}">
                                                {{ $client->nom_entreprise }}
                                            </a>
                                        </dd>
                                        <dt>Fonction : </dt>
                                        <dd>{{ $mission->fonction }}</dd>
                                        <dt>Référence : </dt>
                                        <dd>{{ Config('constants.options.PREFIX_MISSION').$mission->id }}</dd>
                                        <dt>Date : </dt>
                                        <dd>{{ Carbon::parse($mission->created_at)->format('d-m-Y') }}</dd>
                                        <dt>Type de contrat : </dt>
                                        <dd>{{ $mission->typeContrat->type }}</dd>
                                        <dt>Status : </dt>
                                        <dd>{{ $mission->status }}</dd><br \>
                                        <dt>Remarques :</dt>
                                        <dd>{{$mission->remarques}}</dd>
                                    </dl>
                                </div>
                                <div class="col-lg-6">
                                    <dl class="dl-horizontal">
                                        <dt>Contrat :</dt>
                                        <dd>
                                            @if($mission->contrat_id)
                                               <a href="{{ url(Storage::url($mission->contrat->url_document)) }}" target="_blank"> 
                                                   <i class="fa fa-download" aria-hidden="true"></i>
                                                </a>
                                            @else
                                                Aucun contrat
                                            @endif
                                        </dd><br \>

                                        <dt>Job description : </dt>
                                        <dd>
                                        @if(count($mission->job_descriptions))
                                            @foreach($mission->job_descriptions as $job_description)
                                               <a href="{{ url(Storage::url($job_description->url_document)) }}" target="_blank"> 
                                                   <i class="fa fa-download" aria-hidden="true"></i>
                                                   {{ $job_description->description }}
                                                </a></br>
                                            @endforeach
                                        @else
                                            Aucun job description
                                        @endif
                                        </dd><br \>

                                        <dt>Offres : </dt>
                                        <dd>
                                        @if(count($mission->offres))
                                            @foreach($mission->offres as $offre)
                                               <a href="{{ url(Storage::url($offre->url_document)) }}" target="_blank"> 
                                                   <i class="fa fa-download" aria-hidden="true"></i>
                                                   {{ $offre->description }}
                                                </a></br>
                                            @endforeach
                                        @else
                                            Aucune offre
                                        @endif
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 text-right">
                                    {{Form::open([
                                        'route'=>['candidatures.create.from.candidat',0],
                                        'method'=>'GET',
                                        'role'=>'form',
                                        'style' => 'display:inline'
                                    ]) }}
                                        {{ Form::hidden('mission',$mission->id) }}

                                    {{ Form::submit('Ajouter un candidat',['class'=>'btn btn-primary'])}}
                                    {{ Form::close() }}

                                    {{Form::open([
                                        'route'=>['missions.edit',$mission->id],
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
                            <div class="row" style="padding: 10px">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-candidats">
                                            <thead>
                                                <tr>
                                                    <th>Candidats</th>
                                                    <th>Date</th>
                                                    <th>Status</th>
                                                    <th>Avancement</th>
                                                    <th>Média</th>
                                                    <th>Type</th>
                                                    <th>Mode réponse</th>
                                                    <th>Date réponse</th>
                                                    <th>Rapport interview</th>
                                                    <th>Date 1er F2F</th>
                                                    <th>Date client vs candidat</th>
                                                    <th>Date 3e interview</th>
                                                    <th>Remarques</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            @forelse($mission->candidatures as $candidature)
                                                <tr class="odd">
                                                    <td>
                                                        <a href="{{ route('candidats.show',$candidature->candidat->id)}}">
                                                            {{ $candidature->candidat->nom}}&nbsp;{{ $candidature->candidat->prenom }}
                                                        </a>
                                                    </td>
                                                    <td style="white-space:nowrap">
                                                            {{ Carbon::parse($candidature->created_at)->format('d-m-Y') }}
                                                    </td>
                                                    <td>{{ ucfirst($candidature->status->status) }}</td>
                                                    <td>
                                                        {{ ucfirst($candidature->status->avancement) }}   
                                                    </td>
                                                    <td>
                                                        {{ $candidature->modeCandidature->type}} {{ $candidature->modeCandidature->mode}}
                                                    </td>
                                                    <td style="white-space:nowrap">
                                                        {{ $candidature->informationCandidature->information }}
                                                    </td>
                                                    <td>
                                                        {{ $candidature->modeReponse ? $candidature->modeReponse->media :'' }} 
                                                    </td>
                                                    <td style="white-space:nowrap">
                                                        {{ $candidature->date_reponse ? Carbon::parse($candidature->date_reponse)->format('d-m-Y'):'' }}
                                                    </td>
                                                    <td style="text-align:center">
                                                        @if($candidature->rapport)
                                                            <a href="{{ url(Storage::url($candidature->rapport->url_document)) }}" target="_blank"> 
                                                                <i class="fa fa-download" aria-hidden="true"></i>
                                                            </a>
                                                        @else
                                                            Aucun
                                                        @endif
                                                    </td>
                                                    <td style="white-space:nowrap">
                                                        {{ $candidature->F2F ? Carbon::parse($candidature->F2F)->format('d-m-Y'):'' }}
                                                    </td>
                                                    <td style="white-space:nowrap">
                                                        {{ $candidature->rencontreClient ? Carbon::parse($candidature->rencontreClient)->format('d-m-Y'):'' }}
                                                    </td>
                                                    <td style="white-space:nowrap">
                                                        {{ $candidature->rencontre3 ? Carbon::parse($candidature->rencontre3)->format('d-m-Y'):'' }}
                                                    </td>
                                                    <td>
                                                        {{ $candidature->remarques }}
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr><td colspan="12">Aucune candidatures.</td></tr>
                                            @endforelse
                                            
                                            </tbody>
                                        </table>
                                    </div>
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
