@extends('layouts.app')

@section('title',__('general.titles.list_mission'))

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
    },

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
    var table = $('#dataTables-missions').DataTable({
        responsive: true,
        columnDefs: [
            {type:'date-euro', targets: 5},
            {type:'anti-prefix', targets: 0}
        ],
        order: [[5,'desc'],[0,'desc']]
    });

        var $panelHeading = $('.panel-heading');
        $panelHeading.append('<div class="row">');

        var labels = [ '{{ucfirst(trans_choice('general.function',1))}}','{{ucfirst(trans_choice('general.contract',1))}}','{{__('general.status') }}'];

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


@section('content')
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">{{ __('general.titles.list_mission') }}</h1>
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
                        @if($missions->count())
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-missions">
                                <thead>
                                    <tr>
                                        <th>{{ucfirst(trans_choice('general.mission',1))}}</th>
                                        <th>{{ucfirst(trans_choice('general.client',1))}}</th>
                                        <th>{{ucfirst(trans_choice('general.function',1))}}</th>
                                        <th>{{ucfirst(trans_choice('general.contract',1))}}</th>
                                        <th>{{__('general.status') }}</th>
                                        <th>{{ ucfirst(__('general.date')) }}</th>
                                        <th>{{ __('general.notice') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($missions as $mission)
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
                                @endforeach
                                </tbody>
                            </table>
                            <!-- /.table-responsive -->
                        @else
                            <p><strong>Aucune Mission.</strong></p>
                        @endif
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
@endsection
