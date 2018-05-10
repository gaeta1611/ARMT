@extends('layouts.app')

@section('title',__('general.titles.list_client_prospect'))

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


@section('content')
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">{{ __('general.titles.list_client_prospect') }} </h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="row">
                                <div style="width:50px; float: left;margin:0 15px">
                                    <strong>{{__('general.type')}} :</strong>
                                </div>
                                <div style=" float: left">
                                    <ul style="display: inline; padding: 0">
                                        <li style="display: inline">{{ HTML::linkRoute('clients.index',__('general.all')) }} <span>({{ $counters['all'] }})</span></li>
                                        <li style="display: inline">{{ HTML::linkRoute('clients.index',ucfirst(trans_choice('general.client',2)),['status'=>'client']) }} <span>({{ $counters['client'] }})</span></li>
                                        <li style="display: inline">{{ HTML::linkRoute('clients.index',ucfirst(trans_choice('general.prospect',2)),['status'=>'prospect']) }} <span>({{ $counters['prospect'] }})</span></li>                                        
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                        @if($clients->count())
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-clients">
                                <thead>
                                    <tr>
                                        <th>{{ucfirst(trans_choice('general.client',1))}}</th>
                                        <th>{{ ucfirst(__('general.date')) }}</th>
                                        <th>{{ ucfirst(__('general.delete')) }}</th>
                                        <th>{{__('general.add_record',['record'=>trans_choice('general.mission',1)])}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($clients as $client)
                                    <tr class="odd">
                                        <td>
                                            <a href="{{ route('clients.show',$client->id)}}">
                                                {{ $client->nom_entreprise}}
                                            </a>
                                        </td>
                                        <td>{{ Carbon::parse($client->created_at)->format('d-m-Y') }}</td>
                                        <td style="text-align: center">
                                            {{Form::open([
                                                'route'=>['clients.destroy',$client->id],
                                                'method'=>'DELETE',
                                                'role'=>'form',
                                                'onsubmit' => 'return confirm("'.__('general.delete_confirmation',[
                                                    'pronoun'=>trans_choice('general.pronouns.this',1), 
                                                    'record'=>trans_choice('general.client',1),
                                                ]).'")'
                                            ]) }}
                                                <button class="fa fa-trash" aria-hidden="true" title="{{ __('general.delete_record',['record'=>trans_choice('general.client',1)]) }}"></button>                                        
                                            {{ Form::close() }}
                                        </td>
                                        <td style="text-align: center">
                                            {{Form::open([
                                                'route'=>['missions.create.from.client',$client->id],
                                                'method'=>'GET',
                                                'role'=>'form',
                                                'style' => 'display:inline'
                                            ]) }}
                                                <button class="fa fa-plus-circle" aria-hidden="true" title="{{__('general.titles.add_mission')}}"></button>
                                            {{ Form::close() }}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <!-- /.table-responsive -->
                        @else
                            <p><strong>Aucun Client.</strong></p>
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
