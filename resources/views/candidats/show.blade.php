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
                                <div class="col-lg-5">
                                    <dl class="dl-horizontal">
                                        <dt>Nom : </dt>
                                        <dd>{{ $candidat->nom }}</dd>
                                        <dt>Prénom : </dt>
                                        <dd>{{ $candidat->prenom }}</dd>
                                        <dt>Date de naissance : </dt>
                                        <dd>{{ isset($candidat->date_naissance) ? Carbon::parse($candidat->date_naissance)->format('d-m-Y'):'' }} </dd>
                                        <dt>Sexe : </dt>
                                        <dd>{{ $candidat->sexe}}</dd>
                                        <dt>Téléphone : </dt>
                                        <dd>{{ $candidat->telephone }}</dd>
                                        <dt>Localité : </dt>
                                        <dd>{{ $candidat_localite->code_postal }} {{ $candidat_localite->localite }}</dd>
                                        <dt>Email : </dt>
                                        <dd>{{ $candidat->email }}</dd>
                                        <dt>Linkedin : </dt>
                                        <dd>{{ $candidat->linkedin }}</dd>
                                        <dt>Site internet : </dt>
                                        <dd>{{ $candidat->site }}</dd>
                                        <dt>Remarques : </dt>
                                        <dd>{{ $candidat->remarques }}</dd>
                                        <dt>
                                            <a href="{{ $candidat->site }}" target="_blank" style="margin:10px" style="margin:100px"><i class="fa fa-internet-explorer fa-lg" style="margin-top:15px" ></i></a>
                                            <a href="{{ $candidat->linkedin }}" target="_blank" style="margin:10px" ><i class="fa fa-linkedin-square fa-lg"></i></a>
                                            <a href=" mailto:{{ $candidat->email }}" target="_blank" style="margin:10px"><i class="fa fa-envelope-o fa-lg"></i></a>
                                        </dt>
                                    </dl>
                                </div>
                                <div class="col-lg-7">
                                    <dl class="dl-horizontal">                                     
                                        <dt id="diplome">Diplômes : </dt>
                                        @foreach($candidatDiplomeEcoles as $cde)
                                        <dd>
                                            {{ $cde->designation.' '.'('.$cde->niveau.' '.$cde->finalite.')'.' '.'-'.' '.($cde->code_ecole ?? '') }}
                                        </dd>
                                        @endforeach
                                        <br \>
                                        <dt>Dernier Employeur : </dt>
                                        <dd><span class="societe">{{ isset($actualSociety) ? $actualSociety->nom_entreprise:'' }}</span></dd>
                                        <dt>Dernière fonction : </dt>
                                        <dd>{{  isset($lastFunction) ? $lastFunction->fonction:''}} 
                                        @if($lastFunction)
                                            @if($lastFunction->date_debut && $lastFunction->date_fin)
                                            <small>({{Carbon::parse($lastFunction->date_debut)->format('d/m/Y')}} => {{Carbon::parse($lastFunction->date_fin)->format('d/m/Y')}})</small>
                                            @elseif($lastFunction->date_debut)
                                            <small>({{Carbon::parse($lastFunction->date_debut)->format('d/m/Y')}}=>)</small>
                                            @elseif($lastFunction->date_fin)
                                            <small>( => {{Carbon::parse($lastFunction->date_fin)->format('d/m/Y')}})</small>
                                            @endif
                                        @endif
                                        </dd>
                                        <br \>
                                        <dt>Employeurs/fonctions : </dt>
                                        @forelse($societeCandidats as $societeCandidat)
                                        <dd>
                                            <span class="societe">{{ $societeCandidat->societe->nom_entreprise }}</span> - {{$societeCandidat->fonction->fonction ?? 'Pas spécifiée'}}
                                            @if($societeCandidat->date_debut && $societeCandidat->date_fin)
                                            <small>({{Carbon::parse($societeCandidat->date_debut)->format('d/m/Y')}} => {{Carbon::parse($societeCandidat->date_fin)->format('d/m/Y')}})</small>
                                            @elseif($societeCandidat->date_debut)
                                            <small>({{Carbon::parse($societeCandidat->date_debut)->format('d/m/Y')}}=>)</small>
                                            @elseif($societeCandidat->date_fin)
                                            <small>( => {{Carbon::parse($societeCandidat->date_fin)->format('d/m/Y')}})</small>
                                            @endif
                                        </dd>
                                        @empty
                                        <dd></dd>
                                        @endforelse
                                        <br \>
                                        <dt>Langues : <dt>
                                        @foreach($candidat->langues as $langue)
                                        <dd>{{$langue->designation}} (niveau : {{$langue->pivot->niveau}})</dd>
                                        @endforeach
                                        <dt>CV :</dt>
                                        <dd>      
                                        </dd>
                                    </dl>
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col-lg-12 text-right">
                                    {{Form::open([
                                        'route'=>['candidatures.create.from.candidat',$candidat->id],
                                        'method'=>'GET',
                                        'role'=>'form',
                                        'style' => 'display:inline'
                                    ]) }}

                                    {{ Form::submit('Ajouter une candidature',['class'=>'btn btn-primary'])}}
                                    {{ Form::close() }}

                                    {{Form::open([
                                        'route'=>['candidats.edit',$candidat->id],
                                        'method'=>'GET',
                                        'role'=>'form',
                                        'style' => 'display:inline'
                                    ]) }}

                                    {{ Form::submit('Modifier',['class'=>'btn btn-warning'])}}
                                    {{ Form::close() }}
                        
                                    {{Form::open([
                                        'route'=>['candidats.destroy',$candidat->id],
                                        'method'=>'DELETE',
                                        'role'=>'form',
                                        'style' => 'display:inline',
                                        'onsubmit' => 'return confirm("Etes vous sur de vouloir supprimer ce candidat")'
                                    ]) }}
                                    
                                    {{ Form::submit('Supprimer',['class'=>'btn btn-danger'])}}
                                    {{ Form::close() }}
                                </div>
                            </div>
                            <div class="row" style="padding: 10px">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                    @if($candidat->candidatures->count())
                                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-candidats">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>Modifier</th>
                                                    <th>A postulé</th>
                                                    <th>Date</th>
                                                    <th>Média</th>
                                                    <th>Correspond</th>
                                                    <th>Status</th>
                                                    <th>Etat d'avancement</th>
                                                    <th>Mission</th>
                                                    <th>Rapport interview</th>
                                                    <th>Remarques</th>
                                                    <th>Mail</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($candidat->candidatures as $candidature)
                                                <tr class="odd">
                                                    <td>
                                                        <span style="display:none">{{ $candidature->id }}</span>
                                                    </td>
                                                    <td style="text-align:center">
                                                        <a href="{{ route('candidatures.edit',$candidature->id)}}"><i class="fa fa-edit"></i></a>
                                                    </td>
                                                    <td>
                                                        @if($candidature->postule_mission_id)
                                                        <a href="{{ route('missions.show',$candidature->postule_mission_id)}}">
                                                            {{ $candidature->postule_mission->user->initials.$candidature->postule_mission_id }}
                                                        </a>
                                                        @else
                                                            Aucun
                                                        @endif
                                                    </td>
                                                    <td style="white-space:nowrap">
                                                            {{ Carbon::parse($candidature->created_at)->format('d-m-Y') }}
                                                    </td>
                                                    <td>
                                                        {{ $candidature->modeCandidature->type}} {{ $candidature->modeCandidature->mode}}
                                                    </td>
                                                    <td>
                                                        @if($candidature->mission_id)
                                                        <a href="{{ route('missions.show',$candidature->mission_id)}}">
                                                            {{ $candidature->mission->user->initials.$candidature->mission_id}}
                                                        </a>
                                                        @else
                                                            Aucune mission
                                                        @endif
                                                    </td>
                                                    <td>{{ ucfirst($candidature->status->status) }}</td>
                                                    <td>
                                                        {{ ucfirst($candidature->status->avancement) }}   
                                                    </td>
                                                    <td>
                                                        {{ $candidature->mission ? $candidature->mission->status:''}}
                                                    </td>
                                                    <td style="text-align:center" >
                                                        @if($candidature->rapport)
                                                            <a href="{{ Storage::disk('public')->url($candidature->rapport->url_document) }}" target="_blank"> 
                                                                <i class="fa fa-download" aria-hidden="true"></i>
                                                            </a>
                                                        @else
                                                            Aucun
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{ $candidature->remarques }}
                                                    </td>
                                                    <td>
                                                        <i class="fa fa-envelope-o"></i>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    @else   
                                        <p><strong>Aucune candidature pour ce candidat.</strong></p>
                                    @endif
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
