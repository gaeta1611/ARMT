@extends('layouts.app')

@section('title',$title)

@section('css')
@endsection

@section('js')
<script>
    $(function() {
        $('#code_postal')[0].onchange = function(event) { getLocaliteFromCP(this) };
        $('#localite')[0].onchange = function(event) { getCPFromLocalite(this) };
    });
    
    const APP_URL = '{{ Config::get('app.url') }}'; //console.log(APP_URL+ '/public/api/' + table);
    var armtAPI = APP_URL + '/public/api/';

    function getCPFromLocalite(localiteInput) {
        var apiURL = armtAPI+'localite/ville/'+localiteInput.value;

        $.get(apiURL, function(data) {
           if(data.length>0) {
               $('#code_postal').css('border-color','#ccc').val(data[0].code_postal);
               $('#localite').css('border-color','#ccc');
               $('#code_postal').onchange = function() { getLocaliteFromCP(this) };
               
               //Mise à jour du champ caché
               $('#localite_id').val(data[0].id);
           } else {
               var code_postal = $('#code_postal').val();
               apiURL = armtAPI+'localite/cp/'+code_postal;
               
               $.get(apiURL, function(data) {
                   if(data.length>0) {
                        if($('#localite').val()!=data[0].localite) {
                            $('#code_postal').val('');
                        }
                    }
               });
               
               $('#code_postal').css('border-color','red');
               $('#code_postal').onchange = function(event) { event.preventDefault();return false };
               
               //Mise à jour du champ caché
               $('#localite_id').val('');
           }
        });
    }

    function getLocaliteFromCP(cpInput) {
        
        var apiURL = armtAPI+'localite/cp/'+cpInput.value;

        $.get(apiURL, function(data) {
           if(data.length>0) {
               $('#localite').css('border-color','#ccc').val(data[0].localite);
               $('#code_postal').css('border-color','#ccc');
               $('#localite').onchange = function() { getCPFromLocalite(this) };
               
               //Mise à jour du champ caché
               $('#localite_id').val(data[0].id);
           } else {
               var localite = $('#localite').val();
               apiURL = armtAPI+'localite/ville/'+localite;
               
               $.get(apiURL, function(data) {
                   if(data.length>0) {
                        if($('#code_postal').val()!=data[0].code_postal) {
                            $('#localite').val('');
                        }
                    }
               });
               
               $('#localite').css('border-color','red');
               $('#localite').onchange = function(event) { event.preventDefault(); return false };
               
               //Mise à jour du champ caché
               $('#localite_id').val('');
           }
        });
    }
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
                            'role'=>'form'
                        ]) }}
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('prospect','Type:')}}<span class="required">*</span>
                                        {{ Form::radio('prospect','1',
                                            old('prospect')=='1'|| (isset($client) && $client->prospect==1),
                                            (isset($client) && !$client->prospect)?[
                                                'id'=>'prospect',
                                                'disabled'=>'disabled',
                                            ]:[
                                                'id'=>'prospect',
                                            ])}}
                                        {{ Form::label('prospect','Prospect')}}
                                        {{ Form::radio('prospect','0',
                                            old('prospect')=='0'|| (isset($client) && $client->prospect==0),
                                            (isset($client) && !$client->prospect)?[
                                                'id'=>'client',
                                                'disabled'=>'disabled',
                                            ]:[
                                                'id'=>'client',
                                            ])}}
                                        {{ Form::label('client','Client')}} 
                                    </div>
                                    <div class="form-group">
                                        {{ Form::label('nom_entreprise','Nom entreprise:')}}<span class="required">*</span>
                                        {{ Form::text('nom_entreprise',
                                            old('nom_entreprise')?? (isset($client) ? $client->nom_entreprise:''),
                                            [
                                            'placeholder'=>'ex: adva consult',
                                            'class'=>'form-control'
                                        ]) }}
                                    </div>

                                    <div class="form-group">
                                        {{ Form::label('tva','TVA:')}}
                                        {{ Form::text('tva',
                                            old('tva')?? (isset($client) ? $client->tva:''),
                                            [
                                            'placeholder'=>'ex: BE 0 123 456 774',
                                            'class'=>'form-control'
                                        ]) }}
                                    </div>

                                    <div class="form-group">
                                        {{ Form::label('personne_contact','Personne de contact:')}}
                                        {{ Form::text('personne_contact',
                                            old('personne_contact')?? (isset($client) ? $client->personne_contact:''),
                                            [
                                            'placeholder'=>'ex: Prénom Nom ',
                                            'class'=>'form-control'
                                        ]) }}
                                    </div>

                                    <div class="form-group">
                                        {{ Form::label('telephone','Téléphone:')}}
                                        {{ Form::text('telephone',
                                            old('telephone')?? (isset($client) ? $client->telephone:''),
                                            [
                                            'placeholder'=>'ex: 0494/23/58/74',
                                            'class'=>'form-control'
                                        ]) }}
                                    </div>

                                    <div class="form-group">
                                        {{ Form::label('Email','Email:')}}<span class="required">*</span>
                                        <div class="form-group input-group">
                                            <span class="input-group-addon">@</span>
                                            {{ Form::email('email',
                                                old('email')?? (isset($client) ? $client->email:''),
                                                [
                                                'placeholder'=>'mail@example.com',
                                                'class'=>'form-control'
                                            ]) }}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::hidden('localite_id',
                                            old('localite')?? (isset($client) ? $client->localite_id:''),
                                            [
                                                'id'=>'localite_id',
                                        ]) }}
                                        <div class="row">
                                            <div class="col-lg-4 col-xs-4">
                                                {{ Form::label('code_postal','Code postal:') }}
                                                {{ Form::text('code_postal',
                                                old('code_postal')?? (isset($client) ? $client->localite->code_postal : ''),
                                                [
                                                    'placeholder' => 'ex.: 1400',
                                                    'class' => 'form-control',
                                                ]) }}
                                            </div>
                                            <div class="col-lg-8 col-xs-8">
                                                {{ Form::label('localite','Localité:') }}
                                                {{ Form::text('localite',
                                                old('localite')?? (isset($client) ? $client->localite->localite : ''),
                                                [
                                                    'placeholder' => 'ex.: Nivelles',
                                                    'class' => 'form-control',
                                                    'list' => 'list-localites',
                                                ]) }}
                                                <datalist id="list-localites">
                                                @foreach($localites as $localite)   
                                                    <option value="{{ $localite->localite }}">{{ $localite->id }}</option>
                                                @endforeach   
                                                </datalist>
                                        </div>
                                    </div>
                                </div>
                                    <div class="form-group">
                                        {{ Form::label('adresse','Adresse:')}}
                                        {{ Form::text('adresse',
                                            old('adresse')?? (isset($client) ? $client->adresse:''),
                                            [
                                            'placeholder'=>'ex: Chaussée de Mons, 50',
                                            'class'=>'form-control'
                                        ]) }}
                                    </div>

                                    <div class="form-group">
                                        {{ Form::label('site','Site internet:')}}
                                        {{ Form::url('site',
                                            old('site')?? (isset($client) ? $client->site:''),
                                            [
                                            'placeholder'=>'ex: https://www.advaconsult.com',
                                            'class'=>'form-control'
                                        ]) }}
                                    </div>

                                    <div class="form-group">
                                        {{ Form::label('linkedin','LinkedIn:')}}
                                        {{ Form::url('linkedin',
                                            old('linkedin')?? (isset($client) ? $client->linkedin:''),
                                            [
                                            'placeholder'=>'ex: https://www.linkedin.com/in/example',
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
