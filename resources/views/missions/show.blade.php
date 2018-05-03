@extends('layouts.app')

@section('title',$title)

@section('css')

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/dt-1.10.16/r-2.2.1/datatables.min.css"/>
@endsection

@section('js')

<script type="text/javascript" src="https://cdn.datatables.net/v/bs/dt-1.10.16/r-2.2.1/datatables.min.js"></script>
<script>
function fetchDataFrom(table, liste, apiURL) {       
    apiURL += table;

    return $.ajax({
        url:apiURL,
        method: 'GET',
        crossDomain: true,
        dataType: 'json',
        headers: {'Authorization':'Bearer '+API_TOKEN},
        success: function(data){
            $.each(data, function(key, value) {
                liste[key] = value;
            });
        },
    });
}

function postDataInto(table, data, apiURL, jqSelect) {
    console.log(data);
    $.ajax({
        url:apiURL,
        method: 'POST',
        crossDomain: true,
        dataType: 'json',
        data: data,
        headers: {'Authorization':'Bearer '+API_TOKEN},
        success: function(data){
            alert('Candidature modifiée');
        },
        error: function(error){
            alert('Erreur lors de la modification ');
            console.log(error);
        },
    });
}

function fillSelectWith(liste, jqSelect, optionFieldValue, optionFieldText, selectedValue) {
    var strOptions = '';
    
    for(key in liste) {
        if(liste[key][optionFieldText]==selectedValue) {  //Préselectionner l'ancienne 
            strOptions += '<option value="' + liste[key][optionFieldValue] + '" selected>' + liste[key][optionFieldText];
        } else {
            strOptions += '<option value="' + liste[key][optionFieldValue] + '">' + liste[key][optionFieldText];
        }
    }
    jqSelect.append(strOptions);
}

function replaceFormFieldWithValue(jqFormField, $activeRow, dataId) {
    var value = '';

    //Récupérer la valeur sélectionnée
    if(jqFormField.is('select')) {
        value = jqFormField.find('option:selected').text();
    } else if(jqFormField.attr('type')=='date') {
        //Formater la date
        value = reverseDateFormat(jqFormField.val());  //15-04-2018
    } else if(jqFormField.is('textarea')) {
        value = jqFormField.val();

        var breakTag = '<br>';
        value = value.replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
    }

    //Ajouter le texte dans la cellule du tableau (td)
    jqFormField.parent().append(value);

    //Supprimer le champ (liste déroulante (select) ou calendrier (input[date])
    jqFormField.remove();
    
    console.log(dataId);
    //Mise à jour des span, th:visible et th:hidden
    $('#dataTables-candidats th[data-id='+dataId+'],span[data-id='+dataId+']').each(function() {
        var statusCel = $(this);
        
        if(statusCel[0].tagName=='TH') {
            var index = statusCel.index('#dataTables-candidats th');console.log(index);
            statusCel = $activeRow.find('td:eq('+index+')');
        } else {
            statusCel = statusCel.next();
        }

        //Mise à jour du statut
        statusCel.html(value);
        
        $('#dataTables-candidats').DataTable().cell(statusCel[0]).invalidate().draw();
    });
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

function replaceTextWithTextarea(jqParent) {
    //Mémoriser l'ancienne valeur en cas d'annulation
    var oldValue = jqParent.text().trim();

    if(oldValue=='Double-cliquer pour modifier') {
        oldValue ='';
    }
        
    //Vider la cellule (td) et y mettre une liste déroulante (select)
    jqParent.empty().append('<textarea>'+oldValue);

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

/* Formatting function for row details - modify as you need */
function format ( d ) {
    // `d` is the original data object for the row
    var str = '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">';

    for(key in d) {
        str += '<tr class="child">'+
            '<td>'+key+'</td>'+
            '<td>'+d[key]+'</td>'+
        '</tr>';
    }

    str += '</table>';

    return str;
}

function updateStatus(datatable, status, $activeRow) {
    //Mise à jour des span, th:visible et th:hidden
    $(datatable.find('th[data-id=statut],span[data-id=statut]')).each(function() {
        var statusCel = $(this);
        
        if(statusCel[0].tagName=='TH') {
            var index = statusCel.index('#dataTables-candidats th');console.log(index);
            statusCel = $activeRow.find('td:eq('+index+')');
        } else {
            statusCel = statusCel.next();
        }

        //Mise à jour du statut
        statusCel.html(status);
    });
}

var attach = function(element) {
    var $activeTD = $(element);

    if($activeTD[0].tagName=='TD') {    //console.log('TD');
        var $currentTH = $('thead th:eq('+$activeTD.siblings()
                .add(element).index($activeTD)+')');
    } else {    //console.log('SPAN');
        var $currentTH = $($activeTD.parent().find('span.dtr-title')[0]);

    }

    var updateTable = 'candidatures';   //Default table to update
    var updateField = $currentTH.data('field');
    var dataId = $currentTH.data('id');

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
            var updateData = { updateField:updateField, dataId:dataId };

            $select.on('change', null, updateData, function(event) {
                var formattedData = {};
                formattedData[event.data.updateField] = $(this).val();

                //Sélectionner la ligne en cours de modification
                var $activeRow = $($(this).closest('tr'));

                //Corriger la sélection dans le cas d'une ligne enfant (expand/collapse)
                if($activeRow.hasClass('child')) {
                    $activeRow = $activeRow.prev();
                }

                //Sauver dans la base de données                        
                var idCandidature = $activeRow.attr('data-id');
                console.log('Saving candidature n° '+idCandidature);

                var apiURL = armtAPI + updateTable + '/' + idCandidature;
                postDataInto(updateTable, formattedData, apiURL,$(this));

                //Remplacer la liste déroulante par la valeur sélectionnée
                replaceFormFieldWithValue($(this), $activeRow, updateData.dataId);
                
                //Cas particulier de 'statut et avancement'
                if(event.data.updateField=='status_id') {
                    //Rechercher le statut correspondant à l'avancement sélectionné
                    var $selectedText = $(this).find('option:selected').text();

                    for(key in liste) {
                        if(liste[key].avancement==$selectedText) {
                            status = liste[key].status;
                        } 
                    }

                    //Afficher le statut correspondant
                    updateStatus($('#dataTables-candidats'),status, $activeRow);
                }
            });

            //Empêcher le déclenchemt de l'event click sur le body (propagation aux parents)
            $select.on('click', function() { event.stopPropagation(); });
        }).fail(function() { console.log('Erreur d\'accès à l\'API!'); });
    } else {
        var oldValue, $inputDate;
        
        if($activeTD[0].tagName=='TD') {
            var index = $activeTD.index();
            $titleCel = $('#dataTables-candidats th').eq(index);
        } else {    //SPAN
            $titleCel = $activeTD.prev();
        }
        
        if($titleCel.text().indexOf('{{__('general.notice')}}')!=0){
            //Insérer le calendrier à la place du texte
            oldValue = replaceTextWithCalendar($activeTD);
            $inputDate = $activeTD.find('input[type=date]');
            
            $inputDate.on('keypress', null, updateData, function(event) {
                if(event.keyCode==13) {
                    $(this).blur();
                }
            });
        } else {
            //Insérer le textarea à la place du texte
            oldValue = replaceTextWithTextarea($activeTD);
            $inputDate = $activeTD.find('textarea');
        }
        var updateData = { updateField:updateField, dataId:dataId };

        //Si la donnée à modifier est dans une autre table (ex.: interviews)
        if($currentTH.data('bind')) {
            //Récupérer la condition pour retrouver l'enregistrement correspondant
            var updateBind = JSON.parse('{'+$currentTH.data('bind').replace(/'/g,'"')+'}');

            //Ajouter la condition
            updateData.where = updateBind.where;
        }
        
        $inputDate.on('blur', null, updateData, function(event) {   //TODO: add keypress 13
            var formattedData = {};
            formattedData[event.data.updateField] = $(this).val();
            formattedData['where'] = event.data.where;

            //Sélectionner la ligne en cours de modification
            var $activeRow = $($(this).closest('tr'));

            //Corriger la sélection dans le cas d'une ligne enfant (expand/collapse)
            if($activeRow.hasClass('child')) {
                $activeRow = $activeRow.prev();
            }

            //Sauver dans la base de données                        
            var idCandidature = $activeRow.attr('data-id');
            console.log('Saving candidature n° '+idCandidature);

            var apiURL = armtAPI + updateTable + '/' + idCandidature;
            postDataInto(updateTable, formattedData, apiURL,$(this));

            var $td = $(this).parent();

            //Remplacer la liste déroulante par la valeur sélectionnée
            replaceFormFieldWithValue($(this), $activeRow, updateData.dataId);
        });

        //Empêcher le déclenchemt de l'event click sur le body (propagation aux parents)
        $inputDate.on('click', function() { 
            event.stopPropagation(); 
        });
    }
}   

//Remplacer le contenu de la case td par une liste déroulante contenant les valeurs
function attachReplaceWithSelectEventHandler() {
    $('#dataTables-candidats > tbody > tr > td:not(.child), #dataTables-candidats span.dtr-data').each(function(index) {
        $(this).on('dblclick',function() { attach(this); });
    });
}

function dateUS(dateEuro) {
    tDate = dateEuro.split('-');
    return tDate[2]+'-'+tDate[1]+'-'+tDate[0];
}

jQuery.extend( jQuery.fn.dataTableExt.oSort, {
    "date-euro-asc": function ( a, b ) {
        var x = dateUS(a);
        var y = dateUS(b);
        return ((x < y) ? -1 : ((x > y) ? 1 : 0));
    },
 
    "date-euro-desc": function ( a, b ) {
        var x = dateUS(a);
        var y = dateUS(b);
        return ((x < y) ? 1 : ((x > y) ? -1 : 0));
    }
});

$(document).ready(function() {
    //Remplacer le contenu de la case td par une liste déroulante contenant les valeurs
    attachReplaceWithSelectEventHandler();
    
    var datatable = $('#dataTables-candidats').DataTable({
            responsive: {
                details: {
                    renderer: function ( api, rowIdx, columns ) {
                        var data = $.map( columns, function ( col, i ) {
                            switch(col.title) {
                                case '{{__('general.status') }}':
                                    col.data_id = "statut";
                                    break;
                                case '{{__('general.advancement')}}':
                                    col.data_id = "avancement";
                                    col.data_field = "status_id";
                                    col.data_fetch_table = "status.avancement";
                                    break;
                                case '{{__('general.type')}}':
                                    col.data_id = "type";
                                    col.data_field = "information_candidature_id";
                                    col.data_fetch_table = "information_candidature.information";
                                    break;
                                case '{{__('general.response_mode')}}':
                                    col.data_id = "mode_reponse";
                                    col.data_field = "mode_reponse_id";
                                    col.data_fetch_table = "mode_reponse.media";
                                    break;
                                case '{{__('general.response_date')}}':
                                    col.data_id = "date_reponse";
                                    col.data_field = "date_reponse";
                                    break;
                                case '{{__('general.date_f2f')}}':
                                    col.data_id = "date_F2F";
                                    col.data_field = "interviews.date_interview";
                                    col.data_bind = "'foreignKey':'candidature_id','where' : 'type=F2F'";
                                    break;
                                case '{{__('general.date_candidate_client')}}':
                                    col.data_id = "date_candidat_client";
                                    col.data_field = "interviews.date_interview";
                                    col.data_bind = "'foreignKey':'candidature_id','where' : 'type=rencontre client'";
                                    break;
                                case '{{__('general.date_3_interview')}}':
                                    col.data_id = "date_interview3";
                                    col.data_field = "interviews.date_interview";
                                    col.data_bind = "'foreignKey':'candidature_id','where' : 'type=3e rencontre'";
                                    break;
                                case '{{__('general.notice')}}':
                                    col.data_id = "remarques";
                                    col.data_field = "candidatures.remarques";
                                    break;
                            }
                            
                            //console.log(col);
                            var data_id = col.data_id ? 'data-id="'+col.data_id+'"' : '';
                            var data_field = col.data_field ? 'data-field="'+col.data_field+'"' : '';
                            var data_fetch_table = col.data_fetch_table ? 'data-fetch-table="'+col.data_fetch_table+'"' : '';
                            var data_bind = col.data_bind ? 'data-bind="'+col.data_bind+'"' : '';
                            
                            var li = '<li data-dtr-index="'+col.columnIndex+'" data-dt-row="'+col.rowIndex+'" data-dt-column="'+col.columnIndex+'">'+
                                    '<span class="dtr-title" '+data_id+' '+data_field+' '+data_fetch_table+' '+data_bind+'>'+col.title+':</span>'+
                                    '<span class="dtr-data" ondblclick="attach(this)">'+(col.data ? col.data : '<button>Double-cliquer pour modifier</button>')+'</span>'+
                                '</li>';
                            
                            return col.hidden ? li : '';
                        } ).join('');

                        return data ?
                            $('<ul data-dtr-index='+rowIdx+' class=dtr-details />').append( data ) :
                            false;
                    }
                }
            },
            columnDefs: [
                {type:'date-euro', targets: 4}
            ],
            order: [[4,'desc'],[0,'asc']]
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
});
</script>
@endsection


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
                                        <dt>{{ucfirst(trans_choice('general.client',1))}} :</dt>
                                        <dd>
                                            <a href="{{ route('clients.show',$mission->client_id) }}">
                                                {{ $client->nom_entreprise }}
                                            </a>
                                        </dd>
                                        <dt>{{ucfirst(trans_choice('general.function',1))}} :</dt>
                                        <dd>{{ $mission->fonction->fonction }}</dd>
                                        <dt>{{__('general.reference')}} :</dt>
                                        <dd>{{ $mission->user()->get()->first()->initials.$mission->id}}</dd>
                                        <dt>{{ ucfirst(__('general.date')) }} : </dt>
                                        <dd>{{ Carbon::parse($mission->created_at)->format('d-m-Y') }}</dd>
                                        <dt>{{__('general.contract_type')}} :</dt>
                                        <dd>{{ $mission->typeContrat->type }}</dd>
                                        <dt>{{__('general.status')}} : </dt>
                                        <dd>{{ $mission->status }}</dd>
                                        <dt>{{__('general.notice')}} :</dt>
                                        <dd>{{$mission->remarques}}</dd>
                                    </dl>
                                </div>
                                <div class="col-lg-6">
                                    <dl class="dl-horizontal">
                                        <dt>{{ucfirst(trans_choice('general.contract',1))}} :</dt>
                                    @if(auth()->user() && (auth()->user()->is_admin || auth()->user()->id==$mission->user_id))
                                        <dd>
                                            @if($mission->contrat_id)
                                               <a href="{{ Storage::disk('public')->url($mission->contrat->url_document) }}" target="_blank"> 
                                                   <i class="fa fa-download" aria-hidden="true"></i>
                                                </a>
                                            @else
                                                {{ __('general.no_record',['record'=>trans_choice('general.contract',1)]) }}
                                            @endif
                                        </dd><br \>
                                    @else
                                    <dd style="color:red"><i class="fa fa-minus-circle"></i></dd>
                                    @endif

                                        <dt>{{ucfirst(__('general.job_description'))}} :</dt>
                                        @forelse($mission->job_descriptions as $job_description)
                                        <dd>
                                            <a href="{{ Storage::disk('public')->url($job_description->url_document) }}" target="_blank"> 
                                                <i class="fa fa-download" aria-hidden="true"></i>
                                                {{ $job_description->description }}
                                            </a>
                                        </dd>
                                        @empty
                                            <dd>{{ __('general.no_record',['record'=>__('general.job_description')]) }}</dd>
                                        @endforelse <br \>

                                        <dt>{{ucfirst(__('general.offer'))}} :</dt>
                                    @if(auth()->user() && (auth()->user()->is_admin || auth()->user()->id==$mission->user_id))
                                        @forelse($mission->offres as $offre)
                                        <dd>
                                            <a href="{{ Storage::disk('public')->url($offre->url_document) }}" target="_blank"> 
                                                <i class="fa fa-download" aria-hidden="true"></i>
                                                {{ $offre->description }}
                                            </a>
                                        </dd>
                                        @empty
                                            <dd>{{ __('general.no_record',['record'=>__('general.offer')]) }}</dd>
                                        @endforelse
                                    @else
                                        <dd style="color:red"><i class="fa fa-minus-circle"></i></dd>
                                    @endif
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

                                    {{ Form::submit(__('general.titles.add_candidate'),['class'=>'btn btn-primary'])}}
                                    {{ Form::close() }}

                                    {{Form::open([
                                        'route'=>['missions.edit',$mission->id],
                                        'method'=>'GET',
                                        'role'=>'form',
                                        'style' => 'display:inline'
                                    ]) }}

                                    {{ Form::submit(__('general.edit'),['class'=>'btn btn-warning'])}}
                                    {{ Form::close() }}
                        
                                    {{Form::open([
                                        'route'=>['missions.destroy',$mission->id],
                                        'method'=>'DELETE',
                                        'role'=>'form',
                                        'style' => 'display:inline',
                                        'onsubmit' => 'return confirm("'.__('general.delete_confirmation',[
                                            'pronoun'=>trans_choice('general.pronouns.this',3), 
                                            'record'=>trans_choice('general.mission',1),
                                        ]).'")'
                                    ]) }}
                                    
                                    {{ Form::submit(__('general.delete'),['class'=>'btn btn-danger'])}}
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
                                                    <th data-id="candidat">{{__('general.candidate')}}</th>
                                                    <th data-id="diplome">{{__('general.degree')}}</th>
                                                    <th data-id="employeur">{{__('general.employer')}}</th>
                                                    <th data-id="fonction">{{ucfirst(trans_choice('general.function',1))}}</th>
                                                    <th data-id="date">{{ ucfirst(__('general.date')) }}</th>
                                                    <th data-id="statut">{{__('general.status') }}</th>
                                                    <th data-id="avancement" data-field="status_id" data-fetch-table="status.avancement">{{__('general.advancement')}}</th>
                                                    <th data-id="type" data-field="information_candidature_id" data-fetch-table="information_candidature.information">{{__('general.type')}}</th>
                                                    <th data-id="mode_reponse" data-field="mode_reponse_id" data-fetch-table="mode_reponse.media">{{__('general.response_mode')}}</th>
                                                    <th data-id="date_reponse" data-field="date_reponse">{{__('general.response_date')}}</th>
                                                    <th data-id="date_F2F" data-field="interviews.date_interview" data-bind="'foreignKey':'candidature_id','where' : 'type=F2F'">{{__('general.date_f2f')}}</th>
                                                    <th data-id="date_candidat_client" data-field="interviews.date_interview" data-bind="'foreignKey':'candidature_id','where' : 'type=rencontre client'">{{__('general.date_candidate_client')}}</th>
                                                    <th data-id="date_interview3" data-field="interviews.date_interview" data-bind="'foreignKey':'candidature_id','where' : 'type=3e rencontre'">{{__('general.date_3_interview')}}</th>
                                                    <th data-id="media">{{__('general.media')}}</th>
                                                    <th data-id="rapport_interview">{{__('general.interview_rapport')}}</th>
                                                    <th data-id="remarques"  data-field="candidatures.remarques" >{{__('general.notice')}}</th>
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
                                                    @foreach($candidature->candidat->candidatDiplomeEcoles as $cde)
                                                        {{$cde->diplomeEcoles->diplome->code_diplome}} /
                                                    @endforeach
                                                    </td>
                                                    <td>
                                                    @foreach($candidature->candidat->candidatSocietes as $cs)
                                                        @if($cs->societe_actuelle)
                                                            {{$cs->societe->nom_entreprise}} 
                                                             @break
                                                        @endif
                                                    @endforeach
                                                    </td>
                                                    <td>
                                                    @if($candidature->candidat->candidatSocietes->count()!=0 && $candidature->candidat->candidatSocietes[0]->societe->nom_entreprise!="recherche d'emploi")
                                                        {{$candidature->candidat->candidatSocietes[0]->fonction->fonction}}
                                                    @elseif(isset($candidature->candidat->candidatSocietes[1]))
                                                        {{$candidature->candidat->candidatSocietes[1]->fonction->fonction}}   
                                                    @endif()
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
                                                            <a href="{{ Storage::disk('public')->url($candidature->rapport->url_document) }}" target="_blank"> 
                                                                <i class="fa fa-download" aria-hidden="true"></i>
                                                            </a>
                                                        @else
                                                            <dd>{{ __('general.no_record',['record'=>__('general.interview_rapport')]) }}</dd>
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
                                        <p><strong>{{__('general.no_candidate_mission')}}</strong></p>
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
