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
                                        'role'=>'form'
                                    ]) }}
                                    <div class="form-group">
                                        {{ Form::label('postule_mission_id','A postulé :')}}
                                        {{ Form::select('postule_mission_id',
                                            $ongoingMissions,
                                            (isset($oldPostuleMission) ? $oldPostuleMission->id : null),
                                        [
                                            'class'=>'form-control'
                                        ]) }}
                                    </div>
                                    <div class="form-group">
                                        {{ Form::label('date_candidature','Date :')}}
                                        {{ Form::date('date_candidature',
                                            old('date_candidature')?? (isset($candidature) ? $candidat->date_candidature:''),
                                            [
                                            'class'=>'form-control'
                                        ]) }}
                                    </div>

                                    <div class="form-group">
                                        {{ Form::label('media','Média :')}}
                                        {{ Form::select('media',
                                            $listMedias,
                                            (isset($oldMedia) ? $oldMedia->id : null),
                                        [
                                            'class'=>'form-control'
                                        ]) }}
                                    </div>

                                    <div class="form-group">
                                        {{ Form::label('mission_id','Correspond :')}}
                                        {{ Form::select('mission_id',
                                            $ongoingMissions,
                                            (isset($oldMission) ? $oldMission->id : null),
                                        [
                                            'class'=>'form-control'
                                        ]) }}
                                    </div>

                                    <div class="form-group">
                                    {{ Form::label('telephone','Téléphone:')}}
                                    {{ Form::text('telephone',
                                        old('telephone')?? (isset($candidat) ? $candidat->telephone:''),
                                        [
                                        'placeholder'=>'ex: 0494/23/58/74',
                                        'class'=>'form-control'
                                    ]) }}
                                    </div>

                                    <div class="form-group">
                                        {{ Form::label('diplomes','Diplôme:')}}
                                        {{ Form::text('diplome',
                                            old('diplome')?? (isset($candidat) ? $candidat->diplome:''),
                                            [
                                                'placeholder'=>'ex: Bachelier',
                                                'class'=>'form-control',
                                                'list'=>'list-diplomes'
                                        ]) }}
                                        <datalist id="list-diplomes">
                                            <option value="1">Bachelier</option>
                                            <option value="2">Master</option>
                                            <option value="3">Secondaire</option>
                                        </datalist>
                                    </div>

                                    <div class="form-group">
                                        {{ Form::label('societe_candidat','Société antérieur:')}}
                                        {{ Form::text('societe_candidat',
                                            old('societe_candidat')?? (isset($candidat) ? $candidat->societe_candidat:''),
                                            [
                                                'placeholder'=>'ex: Google',
                                                'class'=>'form-control',
                                                'list'=>'list-societe_candidats'
                                        ]) }}
                                        <datalist id="list-societe_candidats">
                                            <option value="1">Google</option>
                                            <option value="2">Facebook</option>
                                            <option value="3">Nasa</option>
                                        </datalist>
                                    </div>

                                    <div class="form-group">
                                        {{ Form::label('societe_candidat','Société actuelle:')}}
                                        {{ Form::text('societe_candidat',
                                            old('societe_candidat')?? (isset($candidat) ? $candidat->societe_candidat:''),
                                            [
                                                'placeholder'=>'ex: Google',
                                                'class'=>'form-control',
                                                'list'=>'list-societe_candidats'
                                        ]) }}
                                        <datalist id="list-societe_candidats">
                                            <option value="1">Google</option>
                                            <option value="2">Facebook</option>
                                            <option value="3">Nasa</option>
                                        </datalist>
                                    </div>

                                    <div class="form-group">
                                        {{ Form::label('fonction','Fonctione exercée:')}}
                                        {{ Form::text('fonction',
                                            old('fonction')?? (isset($candidat) ? $candidat->fonction:''),
                                            [
                                                'placeholder'=>'ex: Manager',
                                                'class'=>'form-control',
                                                'list'=>'list-fonctions'
                                        ]) }}
                                        <datalist id="list-fonctions">
                                            <option value="1">Manager</option>
                                            <option value="2">Responsable marketing</option>
                                            <option value="3">Commercial</option>
                                        </datalist>
                                    </div>
                            </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('localite','Localité:')}}
                                        {{ Form::text('localite',
                                            old('localite')?? (isset($candidat) ? $candidat->localite:''),
                                            [
                                                'placeholder'=>'ex: Nivelles',
                                                'class'=>'form-control',
                                                'list'=>'list-localites'
                                        ]) }}
                                        <datalist id="list-localites">
                                            <option value="1">1000 Bruxelles</option>
                                            <option value="2">1050 Ixelles</option>
                                        </datalist>
                                    </div>

                                    <div class="form-group">
                                        {{ Form::label('Email','Email:')}}
                                        <div class="form-group input-group">
                                            <span class="input-group-addon">@</span>
                                            {{ Form::text('email',
                                                old('email')?? (isset($candidat) ? $candidat->email:''),
                                                [
                                                'placeholder'=>'mail@example.com',
                                                'class'=>'form-control'
                                            ]) }}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        {{ Form::label('linkedin','LinkedIn:')}}
                                        {{ Form::text('linkedin',
                                            old('linkedin')?? (isset($candidat) ? $candidat->linkedin:''),
                                            [
                                            'placeholder'=>'ex: https://www.linkedin.com/in/example',
                                            'class'=>'form-control'
                                        ]) }}
                                    </div>

                                    <div class="form-group">
                                        {{ Form::label('remarques','Remarques:')}}
                                        {{ Form::textarea('remarques',
                                            old('remarques')?? (isset($candidat) ? $candidat->remarques:''),
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
