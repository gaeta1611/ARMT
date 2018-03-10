@extends('layouts.app')

@section('title',$title)

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
    $('#dataTables-candidats').DataTable({
        responsive: true,
        order: [[0,'Candidats']]
    });
    
    //Remplacement des listes déroulantes par leur valeur
    $('body').on('click', function() {
        //Remplacement de la liste déroulante
        $('#dataTables-candidats select').each(function() {
            replaceFormFieldWithValue($(this));
        });
        
        //Remplacement du champ texte
        $('#dataTables-candidats input, #dataTables-candidats textarea').each(function() {
            replaceFormFieldWithValue($(this));
        });
    });
    
    const APP_URL = '{{ Config::get('app.url') }}'; //console.log(APP_URL+ '/public/api/' + table);
    var armtAPI = APP_URL + '/public/api/';
        
    function fetchDataFrom(table, liste, apiURL) {       
        apiURL += table;
        
        return $.getJSON(apiURL,function(data) {
            $.each(data, function(key, value) {
                liste[key] = value;
            });
        });
    }
    
    function postDataInto(table, data, apiURL, jqSelect) {
        $.post(apiURL,data,function(data) {
            //Flash message
            alert('Candidature modifiée');
        }).fail(function(error) {
            //Flash message
            alert('Erreur lors de la modification');
        });
    }
    
    function fillSelectWith(liste, jqSelect, optionFieldValue, optionFieldText, selectedValue) {
        for(key in liste) {
            if(liste[key][optionFieldText]==selectedValue) {  //Préselectionner l'ancienne 
                jqSelect.append('<option value="' + liste[key][optionFieldValue] + '" selected>' + liste[key][optionFieldText]);
            } else {
                jqSelect.append('<option value="' + liste[key][optionFieldValue] + '">' + liste[key][optionFieldText]);
            }
        }
    }
    
    function replaceFormFieldWithValue(jqFormField) {
        var value = '';
        
        //Récupérer la valeur sélectionnée
        if(jqFormField.is('select')) {
            value = jqFormField.find('option:selected').text();
        } else if(jqFormField.attr('type')=='date') {
            //Formater la date
            value = reverseDateFormat(jqFormField.val());  //15-04-2018
        }

        //Ajouter le texte dans la cellule du tableau (td)
        jqFormField.parent().append(value);
        
        //Supprimer le champ (liste déroulante (select) ou calendrier (input[date])
        jqFormField.remove();
    }
    
    function replaceTextWithSelect(jqParent) {
        //Mémoriser l'ancienne valeur en cas d'annulation
        var oldValue = jqParent.text().trim();

        //Vider la cellule (td) et y mettre une liste déroulante (select)
        jqParent.empty().append('<select>');
        
        return oldValue;
    }
    
    function replaceTextWithCalendar(jqParent) {
        //Mémoriser l'ancienne valeur en cas d'annulation
        var oldValue = jqParent.text().trim();  //15-04-2018
        
        //Formater la date
        oldValue = reverseDateFormat(oldValue);  //2018-04-15

        //Vider la cellule (td) et y mettre une liste déroulante (select)
        jqParent.empty().append('<input type="date" value="'+oldValue+'">');
        
        return oldValue;
    }
    
    function reverseDateFormat(date) {
        //Découpage en fonction du séparateur
        if(date.indexOf('-')!=-1) {
            date = date.split('-');
        } else if(date.indexOf('/')!=-1) {
            date = date.split('/');
        }
        
        if(date.length==3) {
            date = date[2]+'-'+date[1]+'-'+date[0];
        }
        
        //En cas d'erreur, la date non modifiée sera renvoyée
        return date;
    }
                    
    //Remplacer le contenu de la case td par une liste déroulante contenant les valeurs
    $('#dataTables-candidats > tbody > tr > td').each(function(index) {
        $(this).on('dblclick',function() {
            var $activeTD = $(this);
            var $currentTH = $('thead th:eq('+$activeTD.siblings()
                    .add(this).index($activeTD)+')');
            
            var updateTable = 'candidatures';   //Default table to update
            var updateField = $currentTH.data('field');
            
            //In case table.field syntax is used
            var parts = updateField.split('.');
            if(parts.length==2) {
                updateTable = parts[0];
                updateField = parts[1];
            }
            
            var fetchTableField = $currentTH.data('fetch-table');
            
            //Récupérer les valeurs de la table source de données
            if(fetchTableField) {
                fetchTableField = fetchTableField.split('.');   //TODO: valider
                var fetchTable = fetchTableField[0];
                var fetchField = fetchTableField[1]; 
            
                var liste = [];

                fetchDataFrom(fetchTable, liste, armtAPI).then(function(data) {
                    //Insérer la liste déroulante à la place du texte
                    var oldValue = replaceTextWithSelect($activeTD);
                    var $select = $activeTD.find('select');

                    //Ajouter dans la liste déroulante (select) les valeurs issues de la DB (liste)
                    fillSelectWith(liste, $select, 'id', fetchField, oldValue); 
                    var updateData = { updateField:updateField };

                    $select.on('change', null, updateData, function(event) {
                        var formattedData = {};
                        formattedData[event.data.updateField] = $(this).val();
                        
                        //Sauver dans la base de données
                        var idCandidature = $(this).parentsUntil('tr').parent().attr('data-id');
                        console.log('Saving candidature n° '+idCandidature);
                        
                        var apiURL = armtAPI + updateTable + '/' + idCandidature;
                        postDataInto(updateTable, formattedData, apiURL,$(this));

                        var $td = $(this).parent();

                        //Remplacer la liste déroulante par la valeur sélectionnée
                        replaceFormFieldWithValue($(this));

                        if(event.data.updateField=='status_id') {
                            //Rechercher le statut correspondant à l'avancement sélectionné
                            var $selectedText = $(this).find('option:selected').text();

                            for(key in liste) {
                                if(liste[key].avancement==$selectedText) {
                                    status = liste[key].status;
                                } 
                            }

                            //Afficher le statut correspondant
                            $td.prev().html(status);
                        }
                    });

                    //Empêcher le déclenchemt de l'event click sur le body (propagation aux parents)
                    $select.on('click', function() { event.stopPropagation(); });
                }).fail(function() { console.log('Erreur d\'accès à l\'API!'); });
            } else {
                //Insérer le calendrier à la place du texte
                var oldValue = replaceTextWithCalendar($activeTD);
                var $inputDate = $activeTD.find('input[type=date]');
                var updateData = { updateField:updateField };

                //Si la données à modifier est dans une autre table (ex:interrviews)
                if($currentTH.data('bind')) {
                    //Récuperer la condidition pour retrouver l'enregistrement correspondant
                     var updateBind = JSON.parse('{'+$currentTH.data('bind').replace(/'/g,'"')+'}');

                     //Ajouter la condidition pour retrouver l'enregistrement correspondant
                     updateData.where = updateBind.where;
                }

                $inputDate.on('change', null, updateData, function(event) {
                    var formattedData = {};
                    formattedData[event.data.updateField] = $(this).val();
                    formattedData['where'] = event.data.where;
                    
                    //Sauver dans la base de données
                    var idCandidature = $(this).parentsUntil('tr').parent().attr('data-id');
                    console.log('Saving candidature n° '+idCandidature);
                        
                    var apiURL = armtAPI + updateTable + '/' + idCandidature;
                    postDataInto(updateTable, formattedData, apiURL,$(this));

                    var $td = $(this).parent();

                    //Remplacer la liste déroulante par la valeur sélectionnée
                    replaceFormFieldWithValue($(this));
                });

                //Empêcher le déclenchemt de l'event click sur le body (propagation aux parents)
                $inputDate.on('click', function() { event.stopPropagation(); });
            }
        });
    });

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
                                    <dl class="dl-horizontal">
                                        <dt>Nom du client : </dt>
                                        <dd>
                                            <a href="{{ route('clients.show',$mission->client_id) }}">
                                                {{ $client->nom_entreprise }}
                                            </a>
                                        </dd>
                                        <dt>Fonction : </dt>
                                        <dd>{{ $mission->fonction->fonction }}</dd>
                                        <dt>Référence : </dt>
                                        <dd>{{ Config('constants.options.PREFIX_MISSION').$mission->id }}</dd>
                                        <dt>Date : </dt>
                                        <dd>{{ Carbon::parse($mission->created_at)->format('d-m-Y') }}</dd>
                                        <dt>Type de contrat : </dt>
                                        <dd>{{ $mission->typeContrat->type }}</dd>
                                        <dt>Status : </dt>
                                        <dd>{{ $mission->status }}</dd>
                                        <dt>Remarques :</dt>
                                        <dd>{{$mission->remarques}}</dd>
                                    </dl>
                                </div>
                                <div class="col-lg-6">
                                    <dl class="dl-horizontal">
                                        <dt>Contrat :</dt>
                                        <dd>
                                            @if($mission->contrat_id)
                                               <a href="{{ url(Storage::url($mission->contrat->url_document)) }}" target="_blank"> 
                                                   <i class="fa fa-download" aria-hidden="true"></i>
                                                </a>
                                            @else
                                                Aucun contrat
                                            @endif
                                        </dd><br \>

                                        <dt>Job description : </dt>
                                        <dd>
                                        @if(count($mission->job_descriptions))
                                            @foreach($mission->job_descriptions as $job_description)
                                               <a href="{{ url(Storage::url($job_description->url_document)) }}" target="_blank"> 
                                                   <i class="fa fa-download" aria-hidden="true"></i>
                                                   {{ $job_description->description }}
                                                </a></br>
                                            @endforeach
                                        @else
                                            Aucun job description
                                        @endif
                                        </dd><br \>

                                        <dt>Offres : </dt>
                                        <dd>
                                        @if(count($mission->offres))
                                            @foreach($mission->offres as $offre)
                                               <a href="{{ url(Storage::url($offre->url_document)) }}" target="_blank"> 
                                                   <i class="fa fa-download" aria-hidden="true"></i>
                                                   {{ $offre->description }}
                                                </a></br>
                                            @endforeach
                                        @else
                                            Aucune offre
                                        @endif
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 text-right">
                                    {{Form::open([
                                        'route'=>['candidatures.create.from.candidat',0],
                                        'method'=>'GET',
                                        'role'=>'form',
                                        'style' => 'display:inline'
                                    ]) }}
                                        {{ Form::hidden('mission',$mission->id) }}

                                    {{ Form::submit('Ajouter un candidat',['class'=>'btn btn-primary'])}}
                                    {{ Form::close() }}

                                    {{Form::open([
                                        'route'=>['missions.edit',$mission->id],
                                        'method'=>'GET',
                                        'role'=>'form',
                                        'style' => 'display:inline'
                                    ]) }}

                                    {{ Form::submit('Modifier',['class'=>'btn btn-warning'])}}
                                    {{ Form::close() }}
                        
                                    {{Form::open([
                                        'route'=>['missions.destroy',$mission->id],
                                        'method'=>'DELETE',
                                        'role'=>'form',
                                        'style' => 'display:inline',
                                        'onsubmit' => 'return confirm("Etes vous sur de vouloir supprimer cette mission")'
                                    ]) }}
                                    
                                    {{ Form::submit('Supprimer',['class'=>'btn btn-danger'])}}
                                    {{ Form::close() }}
                                </div>
                            </div>
                            <div class="row" style="padding: 10px">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                    @if($mission->candidatures->count())
                                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-candidats">
                                            <thead>
                                                <tr>
                                                    <th>Candidats</th>
                                                    <th>Diplômes</th>
                                                    <th>Employeur</th>
                                                    <th>Fonction</th>
                                                    <th>Date</th>
                                                    <th>Status</th>
                                                    <th data-field="status_id" data-fetch-table="status.avancement">Avancement</th>
                                                    <th data-field="information_candidature_id" data-fetch-table="information_candidature.information">Type</th>
                                                    <th data-field="mode_reponse_id" data-fetch-table="mode_reponse.media">Mode réponse</th>
                                                    <th data-field="date_reponse">Date réponse</th>
                                                    <th data-field="interviews.date_interview" data-bind="'foreignKey':'candidature_id','where' : 'type=F2F'">Date 1er F2F</th>
                                                    <th data-field="interviews.date_interview" data-bind="'foreignKey':'candidature_id','where' : 'type=rencontre client'">Date candidat vs client</th>
                                                    <th data-field="interviews.date_interview" data-bind="'foreignKey':'candidature_id','where' : 'type=3e rencontre'">Date 3e interview</th>
                                                    <th>Média</th>
                                                    <th>Rapport interview</th>
                                                    <th>Remarques</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            @foreach($mission->candidatures as $candidature)
                                                <tr class="odd" data-id="{{ $candidature->id }}">
                                                    <td>
                                                        <a href="{{ route('candidats.show',$candidature->candidat->id)}}">
                                                            {{ $candidature->candidat->nom}}&nbsp;{{ $candidature->candidat->prenom }}
                                                        </a>
                                                    </td>
                                                    <td>
                                                    @foreach($candidatDiplomeEcoles as $cde)
                                                        {{$cde->designation}}
                                                    @endforeach
                                                    </td>
                                                    <td>
                                                    @foreach($candidatDiplomeEcoles as $cde)
                                                        {{$cde->designation}}
                                                    @endforeach
                                                    </td>
                                                    <td>
                                                    @foreach($candidatDiplomeEcoles as $cde)
                                                        {{$cde->designation}}
                                                    @endforeach
                                                    </td>
                                                    <td style="white-space:nowrap">
                                                            {{ Carbon::parse($candidature->created_at)->format('d-m-Y') }}
                                                    </td>
                                                    <td>{{ $candidature->status->status }}</td>
                                                    <td>
                                                        {{ $candidature->status->avancement }}   
                                                    </td>
                                                    <td style="white-space:nowrap">
                                                        {{ $candidature->informationCandidature->information }}
                                                    </td>
                                                    <td>
                                                        {{ $candidature->modeReponse ? $candidature->modeReponse->media :'' }} 
                                                    </td>
                                                    <td style="white-space:nowrap">
                                                        {{ $candidature->date_reponse ? Carbon::parse($candidature->date_reponse)->format('d-m-Y'):'' }}
                                                    </td>
                                                    <td style="white-space:nowrap">
                                                        {{ $candidature->F2F ? Carbon::parse($candidature->F2F)->format('d-m-Y'):'' }}
                                                    </td>
                                                    <td style="white-space:nowrap">
                                                        {{ $candidature->rencontreClient ? Carbon::parse($candidature->rencontreClient)->format('d-m-Y'):'' }}
                                                    </td>
                                                    <td style="white-space:nowrap">
                                                        {{ $candidature->rencontre3 ? Carbon::parse($candidature->rencontre3)->format('d-m-Y'):'' }}
                                                    </td>
                                                    <td>
                                                        {{ $candidature->modeCandidature->type}} {{ $candidature->modeCandidature->mode}}
                                                    </td>
                                                    <td style="text-align:center">
                                                        @if($candidature->rapport)
                                                            <a href="{{ url(Storage::url($candidature->rapport->url_document)) }}" target="_blank"> 
                                                                <i class="fa fa-download" aria-hidden="true"></i>
                                                            </a>
                                                        @else
                                                            Aucun
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{ $candidature->remarques }}
                                                    </td>
                                                </tr>
                                    @endforeach
                                            </tbody>
                                        </table>
                                    @else   
                                        <p><strong>Aucun candidat pour cette mission.</strong></p>
                                    @endif
                                    </div>
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
