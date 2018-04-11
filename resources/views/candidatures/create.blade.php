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
                        {{Form::open([
                            'route'=>$route,
                            'method'=>$method,
                            'role'=>'form',
                            'enctype'=>'multipart/form-data'
                        ]) }}
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('candidat_id','Candidat :')}}
                                    @if(empty($candidature) || empty($candidature->candidat_id))
                                        {{ Form::select('candidat_id',
                                            $candidats,
                                            (isset($candidatId) ? $candidatId : null),
                                        [
                                            'class'=>'form-control'
                                        ]) }}
                                    @else
                                    <p>{{ $candidature->candidat()->first()->nom }} {{ $candidature->candidat()->first()->prenom }}</p>
                                        {{ Form::hidden('candidat_id',
                                            $candidature->candidat_id,
                                        [
                                            'id'=>'candidat_id'
                                        ]) }}   
                                    @endif
                                    </div>

                                    <div class="form-group">
                                        {{ Form::label('postule_mission_id','A postulé :')}}
                                        {{ Form::select('postule_mission_id',
                                            $ongoingMissions,
                                            old('postule_mission_id')?? (isset($candidature) ? $candidature->postule_mission_id: null),
                                        [
                                            'class'=>'form-control'
                                        ]) }}
                                    </div>
                                    <div class="form-group">
                                        {{ Form::label('created_at','Date :')}}
                                        {{ Form::date('created_at',
                                            old('created_at')?? (isset($candidature) ? $candidature->created_at: Carbon::now()),
                                            [
                                            'class'=>'form-control'
                                        ]) }}
                                    </div>

                                    <div class="form-group">
                                        {{ Form::label('mode_candidature_id','Média :')}}<span class="required">*</span>
                                        {{ Form::select('mode_candidature_id',
                                            $listMedias,
                                            old('mode_candidature_id')?? (isset($candidature) ? $candidature->mode_candidature_id: null),
                                        [
                                            'class'=>'form-control'
                                        ]) }}
                                    </div>

                                    <div class="form-group">
                                        {{ Form::label('mission_id','Correspond :')}}
                                        {{ Form::select('mission_id',
                                            $ongoingMissions,
                                            (isset($missionId) ? $missionId : null),
                                        [
                                            'class'=>'form-control'
                                        ]) }}
                                    </div>
                                    <div class="form-group">
                                        {{ Form::label('lettre_motivation_id','Charger la lettre de motivation:') }}
                                        @if(isset($candidature) && ($lettre_motivation = $candidature->motivation()->first()))
                                            <a href="{{ Storage::disk('public')->url($lettre_motivation->url_document) }}" target="_blank"> 
                                                <i class="fa fa-download" aria-hidden="true"></i>
                                                {{ $lettre_motivation->filename }}
                                            </a>
                                            <i class="fa fa-times" aria-hidden="true" 
                                                style="margin-top:10px;font-size: 1.5em;color:orangered"
                                                onmouseover="$(this).css('cursor','pointer')"
                                                onclick="$(this).parent().find('a:first-of-type').remove();
                                                        $(this).parent().find('input[type=file]')
                                                                .css('display','block')
                                                                .attr('disabled',false);
                                                        $(this).parent().append('<input type=hidden name=deleteMotivation value=1>')                               
                                                        $(this).remove();">
                                            </i>
                                            {{ Form::hidden('lettre_motivation_id', $candidature->lettre_motivation_id) }}
                                            {{ Form::file('lettre_motivation_id',
                                            [
                                                'style'=>'display:none',
                                                'disabled'=>'disabled'
                                            ]) }}
                                        @else
                                            {{ Form::file('lettre_motivation_id') }}
                                        @endif
                                    </div>       
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('status_id','Etat d\'avancement :') }}
                                        {{ Form::select('status_id',
                                            $listStatus,
                                            old('status_id')?? (isset($candidature) ? $candidature->status_id: null),
                                        [
                                            'class'=>'form-control'
                                        ]) }}
                                    </div>

                                    <div class="form-group">
                                        {{ Form::label('rapport_interview_id','Charger rapport interview:') }}
                                        @if(isset($candidature) && ($rapport_interview = $candidature->rapport()->first()))
                                            <a href="{{ Storage::disk('public')->url($rapport_interview->url_document) }}" target="_blank"> 
                                                <i class="fa fa-download" aria-hidden="true"></i>
                                                {{ $rapport_interview->filename }}
                                            </a>
                                            <i class="fa fa-times" aria-hidden="true" 
                                                style="margin-top:10px;font-size: 1.5em;color:orangered"
                                                onmouseover="$(this).css('cursor','pointer')"
                                                onclick="$(this).parent().find('a:first-of-type').remove();
                                                        $(this).parent().find('input[type=file]')
                                                                .css('display','block')
                                                                .attr('disabled',false);
                                                        $(this).parent().append('<input type=hidden name=deleteRapport value=1>')                               
                                                        $(this).remove();">
                                            </i>
                                            {{ Form::hidden('rapport_interview_id', $candidature->rapport_interview_id) }}
                                            {{ Form::file('rapport_interview_id',
                                            [
                                                'style'=>'display:none',
                                                'disabled'=>'disabled'
                                            ]) }}
                                        @else
                                            {{ Form::file('rapport_interview_id') }}
                                        @endif
                                    </div>
                            
                                    <div class="form-group">
                                        {{ Form::label('remarques','Remarques:')}}
                                        {{ Form::textarea('remarques',
                                            old('remarques')?? (isset($candidature) ? $candidature->remarques:''),
                                            [
                                            'class'=>'form-control'
                                        ]) }}
                                    </div>

                                    <div class="bottom-bar">
                                    {{ Form::submit('Enregistrer',[
                                        'class'=>'btn btn-primary pull-right',
                                    ]) }}
                                        <button class="btn btn-secondary pull-right" type="button"><a href="{{url()->previous()}}">Annuler</a></button>
                                    </div>
                                </div>
                            </div>
                            {{Form::close()}}
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
@endsection
