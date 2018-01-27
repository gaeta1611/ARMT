@extends('layouts.app')

@section('title','Liste des Missions')

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
        var table = $('#dataTables-missions').DataTable({
            responsive: true
        });
 
        table.columns().flatten().each( function ( colIdx ) {
            // Create the select list and search operation
            var select = $('<select />')
                .appendTo(
                    table.column(colIdx).header()
                )
                .on( 'change', function () {
                    table
                        .column( colIdx )
                        .search( $(this).val() )
                        .draw();
                } );
        
            // Get the search data for the first column and add to the select list
            table
                .column( colIdx )
                .cache( 'search' )
                .sort()
                .unique()
                .each( function ( d ) {
                    select.append( $('<option value="'+d+'">'+d+'</option>') );
                } );
        });
    });

</script>
@endsection

@include('includes.sidebar')

@section('content')
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Liste des Missions</h1>
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
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-missions">
                                <thead>
                                    <tr>
                                        <th>Fiche</th>
                                        <th>Client</th>
                                        <th>Fonction</th>
                                        <th>Contrat</th>
                                        <th>Statut</th>
                                        <th>Date</th>
                                        <th>Remarques</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @forelse($missions as $mission)
                                    <tr class="odd">
                                        <td>
                                            <a href="{{ route('missions.show',$mission->id)}}">
                                                {{ Config('constants.options.PREFIX_MISSION').$mission->id}}
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ route('clients.show',$mission->client_id)}}">
                                                {{ $mission->client->nom_entreprise }}
                                            </a>
                                        </td>
                                        <td>
                                            {{ $mission->fonction}}
                                        </td>
                                        <td>
                                            {{ $mission->typeContrat->type}}
                                        </td>
                                        <td>
                                            {{ $mission->status}}
                                        </td>
                                        <td>{{ Carbon::parse($mission->created_at)->format('d-m-Y') }}</td>
                                        <td>
                                            {{ $mission->remarques}}
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5">Aucun mission.</td></tr>
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
