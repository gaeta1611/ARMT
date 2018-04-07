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

        var $panelHeading = $('.panel-heading');
        $panelHeading.append('<div class="row">');

        var labels = ['Fonction','Contrat','Statut'];

        table.columns([2,3,4]).flatten().each( function ( colIdx, index ) {
            $panelHeading.find('.row').append('<div class="col-lg-4"><label for="'+labels[index]+'">'+labels[index]+':<br> ');

            // Create the select list and search operation
            var select = $('<select id="'+labels[index]+'"style="width:165px" />')
                .appendTo(
                    $panelHeading.find('label[for='+labels[index]+']')
                )
                .on( 'change', function () {
                    table
                        .column( colIdx )
                        .search( $(this).val() )
                        .draw();
                } );
        
            // Get the search data for the first column and add to the select list
            select.append( $('<option value=""></option>') );
            table
                .column( colIdx )
                .cache( 'search' )
                .sort()
                .unique()
                .each( function ( d ) {
                    select.append( $('<option value="'+d+'">'+d+'</option>') );
                } );
        });
        //Définir le status par défaut de la mission en fonction du queryString
        if(location.search) {
            var queryFilter = location.search.substring(1+7).replace(/\+/g," ");
            var activeFilter = decodeURIComponent(queryFilter).split('=')[0];
            var activeValue = decodeURIComponent(queryFilter).split('=')[1];
        }
        $('label[for='+activeFilter+'] select').val(activeValue).change(); 
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
                                                {{ $mission->user()->get()->first()->initials.$mission->id}}
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ route('clients.show',$mission->client_id)}}">
                                                {{ $mission->client->nom_entreprise }}
                                            </a>
                                        </td>
                                        <td>
                                            {{ $mission->fonction->fonction }}
                                        </td>
                                        <td>
                                            {{ $mission->typeContrat->type}}
                                        </td>
                                        <td>
                                            {{ $mission->status}}
                                        </td>
                                        <td style="white-space:nowrap">
                                            {{ Carbon::parse($mission->created_at)->format('d-m-Y') }}
                                        </td>
                                        <td>
                                            {{ $mission->remarques}}
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5">Aucune mission.</td></tr>
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
