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

function dateUS(dateEuro) {
    tDate = dateEuro.split('-');
    return tDate[2]+'-'+tDate[1]+'-'+tDate[0];
}

jQuery.extend( jQuery.fn.dataTableExt.oSort, {
    "date-euro-asc": function ( a, b ) {
        var x = dateUS(a);
        var y = dateUS(b);
        return ((x < y) ? -1 : ((x > y) ? 1 : 0));
    },
 
    "date-euro-desc": function ( a, b ) {
        var x = dateUS(a);
        var y = dateUS(b);
        return ((x < y) ? 1 : ((x > y) ? -1 : 0));
    }
});

$(document).ready(function() {
    $('#dataTables-candidats').DataTable({
        responsive: true,
        columnDefs: [
            {type:'date-euro', targets: 4}
        ],
        order: [[4,'desc']]
    });
});
</script>
@endsection


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
                                        <dt>{{ ucfirst(__('validation.attributes.last_name')) }} :</dt>
                                        <dd>{{ $candidat->nom }}</dd>
                                        <dt>{{ ucfirst(__('validation.attributes.first_name')) }} : </dt>
                                        <dd>{{ $candidat->prenom }}</dd>
                                        <dt>{{ __('general.birth_date') }} :</dt>
                                        <dd>{{ isset($candidat->date_naissance) ? Carbon::parse($candidat->date_naissance)->format('d-m-Y'):'' }} </dd>
                                        <dt>{{ __('general.sex') }} :</dt>
                                        <dd>{{ $candidat->sexe}}</dd>
                                        <dt>{{ __('general.phone') }} : </dt>
                                        <dd>{{ $candidat->telephone }}</dd>
                                        <dt>{{ __('general.locality') }} : </dt>
                                        <dd>{{ $candidat_localite->code_postal }} {{ $candidat_localite->localite }}</dd>
                                        <dt>{{ ucfirst(__('validation.attributes.email'))}} :</dt>
                                        <dd>{{ $candidat->email }}</dd>
                                        <dt>{{ __('general.linkedin') }} : </dt>
                                        <dd>{{ $candidat->linkedin }}</dd>
                                        <dt>{{ __('general.website') }} : </dt>
                                        <dd>{{ $candidat->site }}</dd>
                                        <dt>{{ __('general.notice') }} : </dt>
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
                                        <dt id="diplome">{{ __('general.degree') }} : </dt>
                                        @foreach($candidatDiplomeEcoles as $cde)
                                        <dd>
                                            {{ $cde->designation.' '.'('.$cde->niveau.' '.$cde->finalite.')'.' '.'-'.' '.($cde->code_ecole ?? '') }}
                                        </dd>
                                        @endforeach
                                        <br \>
                                        <dt>{{ __('general.last_employer') }} : </dt>
                                        <dd><span class="societe">{{ isset($actualSociety) ? $actualSociety->nom_entreprise:'' }}</span></dd>
                                        <dt>{{ __('general.last_function') }} : </dt>
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
                                        <dt>{{ __('general.employer_function') }} : </dt>
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
                                        <dt>{{ ucfirst(__('validation.attributes.language')) }} : <dt>
                                        @forelse($candidat->langues as $langue)
                                        <dd>{{$langue->designation}} ({{__('general.level')}} : {{$langue->pivot->niveau}})</dd>
                                        @empty
                                        <dd></dd>
                                        @endforelse <br \>
                                        <dt>CV : </dt>
                                        @forelse($candidat->cvs as $cv)
                                        <dd>
                                            <a href="{{ Storage::disk('public')->url($cv->url_document) }}" target="_blank"> 
                                                <i class="fa fa-download" aria-hidden="true"></i>
                                                {{ $cv->description }}
                                            </a>
                                        </dd> 
                                        @empty
                                            <dd>{{ __('general.no_record',['record'=>__('general.cv')]) }}</dd>
                                        @endforelse
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

                                    {{ Form::submit(__('general.titles.add_candidacy'),['class'=>'btn btn-primary'])}}
                                    {{ Form::close() }}

                                    {{Form::open([
                                        'route'=>['candidats.edit',$candidat->id],
                                        'method'=>'GET',
                                        'role'=>'form',
                                        'style' => 'display:inline'
                                    ]) }}

                                    {{ Form::submit(__('general.edit'),['class'=>'btn btn-warning'])}}
                                    {{ Form::close() }}
                        
                                    {{Form::open([
                                        'route'=>['candidats.destroy',$candidat->id],
                                        'method'=>'DELETE',
                                        'role'=>'form',
                                        'style' => 'display:inline',
                                        'onsubmit' => 'return confirm("Etes vous sur de vouloir supprimer ce candidat")'
                                    ]) }}
                                    
                                    {{ Form::submit(__('general.delete'),['class'=>'btn btn-danger'])}}
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
                                                    <th>{{ __('general.edit') }}</th>
                                                    <th>{{ __('general.postuled') }}</th>
                                                    <th title="Lettre de motivation">{{ __('general.cl') }}</th>
                                                    <th>{{ ucfirst(__('general.date')) }}</th>
                                                    <th>{{ __('general.media') }}</th>
                                                    <th>{{ __('general.match') }}</th>
                                                    <th>{{ __('general.status') }}</th>
                                                    <th title="Etat d'avancement">{{ __('general.advancement') }}</th>
                                                    <th>{{ ucfirst(trans_choice('general.mission',1)) }}</th>
                                                    <th>{{ __('general.interview_rapport') }}</th>
                                                    <th>{{ __('general.notice') }}</th>
                                                    <th>{{ __('general.mail') }}</th>
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
                                                    <td style="text-align:center" >
                                                        @if($candidature->motivation)
                                                            <a href="{{ Storage::disk('public')->url($candidature->motivation->url_document) }}" target="_blank"> 
                                                                <i class="fa fa-download" aria-hidden="true"></i>
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
