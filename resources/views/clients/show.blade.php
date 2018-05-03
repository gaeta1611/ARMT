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

function unprefix(missionId) {
    return parseInt($(missionId).text().trim().replace(/^.{2}/i, ""));
}

jQuery.extend( jQuery.fn.dataTableExt.oSort, {
    "anti-prefix-asc": function ( a, b ) {
        a = unprefix(a);
        b = unprefix(b);
        return ((a < b) ? -1 : ((a > b) ? 1 : 0));
    },
 
    "anti-prefix-desc": function ( a, b ) {
        a = unprefix(a);
        b = unprefix(b);
        return ((a < b) ? 1 : ((a > b) ? -1 : 0));
    }
});

$(document).ready(function() {
    $('#dataTables-missions').DataTable({
        responsive: true,
        columnDefs: [
            {type:'anti-prefix', targets: 0}
        ],
        order: [[0,'desc']]
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
                                <div class="col-lg-6">
                                    <dl class="dl-horizontal">
                                        <dt>{{__('general.company_name')}} : </dt>
                                        <dd>{{ $client->nom_entreprise }}</dd>
                                        <dt>{{__('general.vat')}} : </dt>
                                        <dd>{{ $client->tva }}</dd>
                                        <dt>{{__('general.contact_person')}} :</dt>
                                        <dd>{{ $client->personne_contact }}</dd>
                                        <dt>{{__('general.phone')}} : </dt>
                                        <dd>{{ $client->telephone }}</dd>
                                        <dt>{{ ucfirst(__('validation.attributes.email')) }} : </dt>
                                        <dd>{{ $client->email }}</dd>
                                        <dt>
                                        <a href="{{ $client->site }}" target="_blank" style="margin:10px"><i class="fa fa-internet-explorer fa-lg" style="margin-top:15px"></i></a>
                                        <a href="{{ $client->linkedin }}" target="_blank" style="margin:10px" ><i class="fa fa-linkedin-square fa-lg"></i></a>
                                        <a href=" mailto:{{ $client->email }}" target="_blank" style="margin:10px"><i class="fa fa-envelope-o fa-lg"></i></a>
                                        </dt>
                                    </dl>
                                </div>
                                <div class="col-lg-6">
                                    <dl class="dl-horizontal">
                                        <dt>{{__('general.locality')}} :  </dt>
                                    @if(isset($client->localite))
                                        <dd> {{ $client->localite->code_postal }}, {{ $client->localite->localite }}</dd>
                                    @else
                                        <dd></dd>
                                    @endif
                                        <dt>{{__('general.address')}} :  </dt>
                                        <dd>{{ $client->adresse }}</dd>
                                        <dt>{{__('general.website')}} :  </dt>
                                        <dd>{{ $client->site }}</dd>
                                        <dt>{{__('general.linkedin')}} :  </dt>
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

                                    {{ Form::submit(__('general.titles.add_mission'),['class'=>'btn btn-primary'])}}
                                    {{ Form::close() }}

                                    {{Form::open([
                                        'route'=>['clients.edit',$client->id],
                                        'method'=>'GET',
                                        'role'=>'form',
                                        'style' => 'display:inline'
                                    ]) }}

                                    {{ Form::submit(__('general.edit'),['class'=>'btn btn-warning'])}}
                                    {{ Form::close() }}
                        
                                    {{Form::open([
                                        'route'=>['clients.destroy',$client->id],
                                        'method'=>'DELETE',
                                        'role'=>'form',
                                        'style' => 'display:inline',
                                        'onsubmit' => 'return confirm("'.__('general.delete_confirmation',[
                                            'pronoun'=>trans_choice('general.pronouns.this',1), 
                                            'record'=>trans_choice('general.client',1),
                                        ]).'")'
                                    ]) }}
                                    
                                    {{ Form::submit(__('general.delete'),['class'=>'btn btn-danger'])}}
                                    {{ Form::close() }}
                                </div>
                            </div>
                            <div class="row" style="padding: 10px">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-missions">
                                            <thead>
                                                <tr>
                                                    <th>{{ucfirst(trans_choice('general.mission',1))}}</th>
                                                    <th>{{ucfirst(trans_choice('general.function',1))}}</th>
                                                    <th>{{ ucfirst(__('general.date')) }}</th>
                                                    <th>{{ __('general.notice') }}</th>
                                                    <th>{{__('general.status') }}</th>
                                                    <th>{{ ucfirst(__('general.delete')) }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @forelse($client->missions as $mission)
                                                <tr class="odd">
                                                    <td>
                                                        <a href="{{ route('missions.show',$mission->id)}}">
                                                            {{ $mission->user()->get()->first()->initials.$mission->id}}
                                                        </a>
                                                    </td>
                                                    <td>
                                                            {{ $mission->fonction->fonction}}
                                                    </td>
                                                    <td style="white-space:nowrap">
                                                        {{ Carbon::parse($mission->created_at)->format('d-m-Y') }}
                                                    </td>
                                                    <td>
                                                            {{ $mission->remarques}}
                                                    </td>
                                                    <td>
                                                            {{ $mission->status}}
                                                    </td>
                                                    <td style="text-align: center">
                                                        {{Form::open([
                                                            'route'=>['missions.destroy',$mission->id],
                                                            'method'=>'DELETE',
                                                            'role'=>'form',
                                                            'onsubmit' => 'return confirm("'.__('general.delete_confirmation',[
                                                                'pronoun'=>trans_choice('general.pronouns.this',3), 
                                                                'record'=>trans_choice('general.mission',1),
                                                            ]).'")'
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
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
@endsection
