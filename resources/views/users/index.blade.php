@extends('layouts.app')

@section('title','Liste des utilisateurs')

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
                    <h1 class="page-header">Liste des utilisateurs</h1>
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
                                        <th>Initiales</th>
                                        <th>Utilisateur</th>
                                        <th>Email</th>
                                        <th>Langue</th>
                                        <th>Date de création</th>
                                        <th>Supprimer</th>
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
                                                'onsubmit' => 'return confirm("Etes vous sur de vouloir supprimer ce user")'
                                            ]) }}
                                                <button class="fa fa-trash" aria-hidden="true" title="supprimer user"></button>                                        
                                            {{ Form::close() }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5">Aucun Utilisateur.</td></tr>
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
