@extends('layouts.app')

@section('title',__('general.record_list',['record'=>trans_choice('general.user',10)]))

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
        $('#dataTables-users').DataTable({
            responsive: true
        });
    });
</script>
@endsection

@include('includes.sidebar')

@section('content')
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">{{ ucfirst(__('general.record_list',['record'=>trans_choice('general.user',2)])) }}</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-users">
                                <thead>
                                    <tr>
                                        <th>{{ ucfirst(__('validation.attributes.initials')) }}</th>
                                        <th>{{ ucfirst(trans_choice('general.user',1)) }}</th>
                                        <th>{{ ucfirst(__('validation.attributes.email')) }}</th>
                                        <th>{{ ucfirst(__('validation.attributes.language')) }}</th>
                                        <th>{{ ucfirst(__('general.created_at')) }}</th>
                                        <th>{{ ucfirst(__('general.delete')) }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @forelse($users as $user)
                                    <tr class="odd">
                                        <td> {{ $user->initials}}</td>
                                        <td>
                                            <a href=" {{ route('users.show', $user->id)}}">
                                                {{ $user->lastname }} {{ $user->firstname }}
                                            </a>
                                        </td>
                                        <td> {{ $user->email}}</td>
                                        <td> {{ $user->language}}</td>
                                        <td> {{ Carbon::parse($user->created_at)->format('d-m-Y') }}</td>
                                        <td style="text-align: center">
                                            {{Form::open([
                                                'route'=>['users.destroy',$user->id],
                                                'method'=>'DELETE',
                                                'role'=>'form',
                                                'onsubmit' => 'return confirm("'.__('general.delete_confirmation',[
                                                    'pronoun'=>trans_choice('general.pronouns.this',2), 
                                                    'record'=>trans_choice('general.user',1),
                                                ]).'")'
                                            ]) }}
                                                <button class="fa fa-trash" aria-hidden="true" title="{{ __('general.delete_record',['record'=>trans_choice('general.user',1)]) }}"></button>                                        
                                            {{ Form::close() }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5">{{ __('general.no_record',['record'=>trans_choice('general.user',1)]) }}</td></tr>
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
