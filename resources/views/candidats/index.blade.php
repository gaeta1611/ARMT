@extends('layouts.app')

@section('title','Liste des candidats')

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
            responsive: true
        });
    });
</script>
@endsection

@include('includes.sidebar')

@section('content')
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Liste des candidats</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Ajouter les filtres
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-candidats">
                                <thead>
                                    <tr>
                                        <th>Nom</th>
                                        <th>Prenom</th>
                                        <th>Date de naissance</th>
                                        <th>Date de création</th>
                                        <th>Supprimer</th>
                                        <th>Ajouter à une fiche</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @forelse($candidats as $candidat)
                                    <tr class="odd">
                                        <td>
                                            <a href="{{ route('candidats.show',$candidat->id)}}">
                                                {{ $candidat->nom}}
                                            </a>
                                        </td>
                                        <td>
                                            {{ $candidat->prenom}}
                                        </td>
                                        <td>
                                            {{ Carbon::parse($candidat->date_naissance)->format('d-m-Y') }}
                                        </td>
                                        <td>{{ Carbon::parse($candidat->created_at)->format('d-m-Y') }}</td>
                                        <td style="text-align: center">
                                            {{Form::open([
                                                'route'=>['candidats.destroy',$candidat->id],
                                                'method'=>'DELETE',
                                                'role'=>'form',
                                                'onsubmit' => 'return confirm("Etes vous sur de vouloir supprimer ce candidat")'
                                            ]) }}
                                                <button class="fa fa-trash" aria-hidden="true" title="supprimer candidat"></button>                                        
                                            {{ Form::close() }}
                                        </td>
                                        
                                        <td style="text-align: center">
                                            {{ Form::open([
                                                'route'=>['candidatures.store'],
                                                'method'=>'POST'
                                            ]) }}
                                            {{ Form::hidden('candidat_id',$candidat->id) }}
                                            {{ Form::select('mission_id',$ongoingMissions,'0') }}
                                            {{ Form::submit('OK') }}
                                            {{ Form::close() }}
                                        </td>
                                        
                                    </tr>
                                @empty
                                    <tr><td colspan="5">Aucun candidat.</td></tr>
                                @endforelse
                                </tbody>
                            </table>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
@endsection
