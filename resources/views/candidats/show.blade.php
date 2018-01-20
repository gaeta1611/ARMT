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
                                <div class="col-lg-6">
                                    <dl class="dl-horizontal">
                                        <dt>Nom : </dt>
                                        <dd>{{ $candidat->nom }}</dd>
                                        <dt>Prénom : </dt>
                                        <dd>{{ $candidat->prenom }}</dd>
                                        <dt>Date de naissance : </dt>
                                        <dd>{{ Carbon::parse($candidat->date_naissance)->format('d-m-Y') }} </dd>
                                        <dt>Sexe : </dt>
                                        <dd>{{ $candidat->sexe}}</dd>
                                        <dt>Téléphone : </dt>
                                        <dd>{{ $candidat->telephone }}</dd>
                                    </dl>
                                    <a href="{{ $candidat->linkedin }}" target="_blank" style="margin:25px" ><i class="fa fa-linkedin-square fa-lg"></i></a>
                                    <a href=" mailto:{{ $candidat->email }}" target="_blank" style="margin:2px"><i class="fa fa-envelope-o fa-lg"></i></a>                                
                                </div>
                                <div class="col-lg-6">
                                    <dl class="dl-horizontal">
                                        <dt>Localité : </dt>
                                        <dd>{{ $candidat_localite->code_postal }} {{ $candidat_localite->localite }}</dd>
                                        <dt>Email : </dt>
                                        <dd>{{ $candidat->email }}</dd>
                                        <dt>Linkedin : </dt>
                                        <dd>{{ $candidat->linkedin }}</dd>
                                        <dt>Remarques : </dt>
                                        <dd>{{ $candidat->remarques }}</dd>
                                    </dl>
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col-lg-12 text-right">
                                    {{Form::open([
                                        'route'=>['candidats.create.from.candidat',$candidat->id],
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
                                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-candidats">
                                            <thead>
                                                <tr>
                                                    <th>A postulé</th>
                                                    <th>Date</th>
                                                    <th>Source</th>
                                                    <th>Correspond</th>
                                                    <th>Status</th>
                                                    <th>Etat d'avancement</th>
                                                    <th>Remarques</th>
                                                    <th>Mail</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                            
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
