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
                                        {{ Form::label('nom_entreprise','Nom entreprise:')}}
                                        {{ Form::text('nom_entreprise',
                                            old('nom_entreprise')?? isset($client) ? $client->nom_entreprise:'',
                                            [
                                            'placeholder'=>'ex: adva consult',
                                            'class'=>'form-control'
                                        ]) }}
                                    </div>

                                    <div class="form-group">
                                        {{ Form::label('tva','TVA:')}}
                                        {{ Form::text('tva',
                                            old('tva')?? isset($client) ? $client->tva:'',
                                            [
                                            'placeholder'=>'ex: BE 0 123 456 774',
                                            'class'=>'form-control'
                                        ]) }}
                                    </div>

                                    <div class="form-group">
                                        {{ Form::label('personne_contact','Personne de contact:')}}
                                        {{ Form::text('personne_contact',
                                            old('personne_contact')?? isset($client) ? $client->personne_contact:'',
                                            [
                                            'placeholder'=>'ex: Prénom Nom ',
                                            'class'=>'form-control'
                                        ]) }}
                                    </div>

                                    <div class="form-group">
                                        {{ Form::label('telephone','Téléphone:')}}
                                        {{ Form::text('telephone',
                                            old('telephone')?? isset($client) ? $client->telephone:'',
                                            [
                                            'placeholder'=>'ex: 0494/23/58/74',
                                            'class'=>'form-control'
                                        ]) }}
                                    </div>

                                    <div class="form-group">
                                        {{ Form::label('Email','Email:')}}
                                        <div class="form-group input-group">
                                            <span class="input-group-addon">@</span>
                                            {{ Form::text('email',
                                                old('email')?? isset($client) ? $client->email:'',
                                                [
                                                'placeholder'=>'mail@example.com',
                                                'class'=>'form-control'
                                            ]) }}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('localite','Localité:')}}
                                        {{ Form::text('localite',
                                            old('localite')?? isset($client) ? $client->localite:'',
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
                                        {{ Form::label('adresse','Adresse:')}}
                                        {{ Form::text('adresse',
                                            old('adresse')?? isset($client) ? $client->adresse:'',
                                            [
                                            'placeholder'=>'ex: Chaussée de Mons, 50',
                                            'class'=>'form-control'
                                        ]) }}
                                    </div>

                                    <div class="form-group">
                                        {{ Form::label('site','Site internet:')}}
                                        {{ Form::text('site',
                                            old('site')?? isset($client) ? $client->site:'',
                                            [
                                            'placeholder'=>'ex: https://www.advaconsult.com',
                                            'class'=>'form-control'
                                        ]) }}
                                    </div>

                                    <div class="form-group">
                                        {{ Form::label('linkedin','LinkedIn:')}}
                                        {{ Form::text('linkedin',
                                            old('linkedin')?? isset($client) ? $client->linkedin:'',
                                            [
                                            'placeholder'=>'ex: https://www.linkedin.com/in/example',
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
