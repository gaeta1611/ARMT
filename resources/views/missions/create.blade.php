@extends('layouts.app')

@section('title',$title)

@section('css')
@endsection

@section('js')
<script>
    $('#date-creation input').datepicker({
        weekStart: 1,
        todayBtn: "linked",
        language: "fr",
        multidateSeparator: "."
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
                                    {{Form::open([
                                        'route'=>$route,
                                        'method'=>$method,
                                        'role'=>'form',
                                        'enctype'=>'multipart/form-data'
                                    ]) }}
                                    <div class="form-group">
                                        
                                        {{ Form::label('client_id','Nom du client:')}}
                                        {{ Form::select('client_id',
                                            $clients,
                                            (isset($oldClient) ? $oldClient->id : null),
                                        [
                                            'class'=>'form-control'
                                        ]) }}
                                    </div>

                                    <div class="form-group">
                                        {{ Form::label('fonction','Fonction:')}}
                                        {{ Form::text('fonction',
                                            old('fonction')?? (isset($mission) ? $mission->fonction:''),
                                            [
                                                'placeholder'=>'ex: Ingénieur construction',
                                                'class'=>'form-control',
                                                'list'=>'list-fonctions',
                                        ]) }}
                                        <datalist id="list-fonctions">
                                            <option value="1">Ingénieur</option>
                                            <option value="2">traducteur</option>
                                        </datalist>
                                    </div>

                                    <div class="form-group">
                                        {{ Form::label('type_contrat_id','Type de contrat:')}}
                                        {{ Form::select('type_contrat_id', 
                                            $typesContrat,
                                            (isset($mission) ? $mission->type_contrat_id: null),
                                            [
                                            'class'=>'form-control'
                                        ]) }}
                                    </div>

                                    <div class="form-group">
                                        {{ Form::label('status','Status de la mission:')}}
                                        {{ Form::select('status',
                                            $listeStatus,
                                            (isset($mission) ? $mission->status: 'En cours'),
                                            [
                                            'class'=>'form-control'
                                        ]) }}
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('contrat_id','Charger contrat:')}}
                                        {{ Form::file('contrat_id',[ 1 => 
                                            old('contrat_id')?? (isset($mission) ? $mission->contrat_id:'1')],
                                            [
                                            'class'=>'form-control'
                                        ]) }}
                                    </div>

                                    <div class="form-group">
                                        {{ Form::label('job_description_id','Charger le/les job descriptions:')}}
                                        {{ Form::file('job_description_id',[ 1 => 
                                            old('job_description_id')?? (isset($mission) ? $mission->job_description_id:'1')],
                                            [
                                            'class'=>'form-control'
                                        ]) }}
                                    </div>

                                    <div class="form-group">
                                        {{ Form::label('remarques','Remarques:')}}
                                        {{ Form::textarea('remarques',
                                            old('remarques')?? (isset($mission) ? $mission->remarques:''),
                                            [
                                            'class'=>'form-control'
                                        ]) }}
                                    </div>

                                    <div style="margin-top:35px">
                                    {{ Form::submit('Enregistrer',['class'=>'btn btn-primary pull-right'])}}
                                    </div>

                                    {{Form::close()}}
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
