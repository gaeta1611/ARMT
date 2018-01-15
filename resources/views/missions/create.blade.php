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
                                        @if(isset($mission) && $mission->contrat_id)
                                            <a href="{{ url(Storage::url($mission->contrat->url_document)) }}" target="_blank"> 
                                                <i class="fa fa-download" aria-hidden="true"></i>
                                                {{$mission->contrat->filename}}
                                            </a>
                                            <i class="fa fa-times" aria-hidden="true" 
                                                style="margin-top:10px;font-size: 1.5em;color:orangered"
                                                onmouseover="$(this).css('cursor','pointer')"
                                                onclick="$(this).parent().find('a:first-of-type').remove();
                                                        $(this).parent().find('input[type=file]')
                                                                .css('display','block')
                                                                .attr('disabled',false);                               
                                                        $(this).remove();">
                                            </i>
                                            {{ Form::hidden('contrat_id', $mission->contrat_id) }}
                                            {{ Form::file('contrat_id',
                                            [
                                                'style'=>'display:none',
                                                'disabled'=>'disabled'
                                            ]) }}
                                        @else
                                            {{ Form::file('contrat_id') }}
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <dl>
                                            <dt>{{ Form::label('job_description_ids','Charger le/les job descriptions:') }}</dt>
                                        @if(isset($mission) && $mission->job_descriptions)
                                            <dd style="margin-left:15px">
                                            @foreach($mission->job_descriptions as $job_description)
                                               <a href="{{ url(Storage::url($job_description->url_document)) }}" target="_blank"> 
                                                   <i class="fa fa-download" aria-hidden="true"></i>
                                                   {{ $job_description->description }}
                                                </a>
                                                <i class="fa fa-times" aria-hidden="true" 
                                                style="margin-top:10px;font-size: 1.1em;color:orangered"
                                                onmouseover="$(this).css('cursor','pointer')"
                                                onclick="$(this).parent().find('a:first-of-type,br').remove(); 
                                                        $(this).remove();">
                                                </i></br>
                                            @endforeach
                                            <dd>
                                        @endif
                                        </dl>
                                        <div class="m-1-2" style="margin-left: 20px; font-size: 0.9em">
                                            <div>
                                                {{ Form::label('descriptions[]','Description:')}}
                                                {{ Form::text('descriptions[]',
                                                    old('descriptions[]')?? (isset($mission) ? $mission->description:''),
                                                    [
                                                        'placeholder'=>'ex: Français',
                                                        'class'=>'form-control',
                                                        'style'=>'display:inline;width:auto;height:1.8em;margin-bottom:5px'
                                                ]) }}


                                                {{ Form::file('job_description_ids[]',[ 1 => 
                                                    old('job_description_id')?? (isset($mission) ? $mission->job_description_id:'1')],
                                                    [
                                                    'class'=>'form-control'
                                                ]) }}
                                            </div>

                                            <i class="fa fa-plus-square" aria-hidden="true" 
                                            style="margin-top:10px;font-size: 1.5em;color:blue"
                                            onmouseover="$(this).css({'cursor':'pointer','color':'Darkblue'})"
                                            onmouseout="$(this).css({'cursor':'pointer','color':'blue'})"
                                            onclick="$divs = $(this).parent().find('div')
                                                    $lastDiv = $divs.last();
                                                    if($divs.length==1 && $lastDiv.find('input[type=file]').attr('disabled')){
                                                        $lastDiv.css('display','block');
                                                        $lastDiv.find('input[type=file]').attr('disabled',false);                      
                                                     }
                                                     else{
                                                        $div = $lastDiv.clone();
                                                        $div.insertBefore($(this));
                                                        $div.parent().find('input[type=file]').last().val('');
                                                        $div.parent().find('input[type=text]').last().val('');
                                                         
                                                     }">
                                            </i>
                                            <i class="fa fa-minus-square" aria-hidden="true" 
                                            style="margin-top:10px;font-size: 1.5em;color:orangered"
                                            onmouseover="$(this).css({'cursor':'pointer','color':'darkred'})"
                                            onmouseout="$(this).css({'cursor':'pointer','color':'orangered'})"
                                            onclick="$divs = $(this).parent().find('div');
                                                     if($divs.length>1){
                                                        $divs.last().remove();
                                                     }
                                                     else{
                                                         $divs.last().css('display','none');
                                                         $divs.last().find('input[type=file]')
                                                                    .attr('disabled',true)
                                                                    .val('');
                                                         $div.last().find('input[type=text]').val('');
                                                     }">
                                            </i>
                                        </div>
                                        
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
