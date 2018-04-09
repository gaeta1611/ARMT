@extends('layouts.app')

@section('title',ucfirst(trans_choice('general.user',1)).' : '.($user->firstname).' '.($user->lastname))

@section('css')
@endsection

@section('js')
@endsection

@include('includes.sidebar')

@section('content')
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">{{ ucfirst(trans_choice('general.user',1)).' : '.($user->firstname).' '.($user->lastname) }}</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <dl class="dl-horizontal">
                                        <dt>{{ ucfirst(__('validation.attributes.last_name')) }} : </dt>
                                        <dd>{{ $user->lastname }}</dd>
                                        <dt>{{ ucfirst(__('validation.attributes.first_name')) }} : </dt>
                                        <dd>{{ $user->firstname }}</dd>
                                        <dt>{{ ucfirst(__('validation.attributes.initials')) }} :  </dt>
                                        <dd>{{ $user->initials }}</dd>
                                        <dt>{{ ucfirst(__('validation.attributes.login')) }} : </dt>
                                        <dd>{{ $user->login }}</dd>
                                        <dt>{{ ucfirst(__('validation.attributes.email')) }} : </dt>
                                        <dd>{{ $user->email }}</dd>
                                        <dt>{{ ucfirst(__('validation.attributes.language')) }} : </dt>
                                        <dd>{{ $user->language }}</dd>
                                    </dl>
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col-lg-12 text-right">
                                    {{Form::open([
                                        'route'=>['users.edit',$user->id],
                                        'method'=>'GET',
                                        'role'=>'form',
                                        'style' => 'display:inline'
                                    ]) }}

                                    {{ Form::submit(__('general.edit'),['class'=>'btn btn-warning'])}}
                                    {{ Form::close() }}
                        
                                    {{Form::open([
                                        'route'=>['users.destroy',$user->id],
                                        'method'=>'DELETE',
                                        'role'=>'form',
                                        'style' => 'display:inline',
                                        'onsubmit' => 'return confirm("'.__('general.delete_confirmation',[
                                            'pronoun'=>trans_choice('general.pronouns.this',2), 
                                            'record'=>trans_choice('general.user',1),
                                        ]).'")'
                                    ]) }}
                                    
                                    {{ Form::submit(__('general.delete'),['class'=>'btn btn-danger'])}}
                                    {{ Form::close() }}
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
