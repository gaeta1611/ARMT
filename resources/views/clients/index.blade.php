@extends('layouts.app')

@section('title','Liste des clients')

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
        $('#dataTables-clients').DataTable({
            responsive: true
        });
    });
</script>
@endsection

@include('includes.sidebar')

@section('content')
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Liste des clients</h1>
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
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-clients">
                                <thead>
                                    <tr>
                                        <th>Clients</th>
                                        <th>Date</th>
                                        <th>Profil client</th>
                                        <th>Supprimer</th>
                                        <th>Ajouter fiche</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @forelse($clients as $client)
                                    <tr class="odd">
                                        <td>
                                            <a href="{{ route('clients.show',$client->id)}}">
                                                {{ $client->nom_entreprise}}
                                            </a>
                                        </td>
                                        <td>{{ Carbon::parse($client->created_at)->format('d-m-Y') }}</td>
                                        <td style="text-align: center">
                                            <a href="{{ route('clients.show',$client->id)}}">
                                                <i class="fa fa-eye" aria-hidden="true" title="afficher client"></i>
                                            </a>
                                        </td>
                                        <td style="text-align: center">
                                            <a href="{{ route('clients.destroy',$client->id)}}">
                                                <i class="fa fa-trash" aria-hidden="true" title="supprimer client"></i>
                                            </a>
                                        </td>
                                        <td style="text-align: center">
                                            <a href="{{ route('clients.show',$client->id)}}">
                                                <i class="fa fa-plus-circle" aria-hidden="true" title="ajouter une nouvelle fiche"></i>
                                            </a>
                                        </td>
                                        
                                    </tr>
                                @empty
                                    <tr><td colspan="5">Aucun client.</td></tr>
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
