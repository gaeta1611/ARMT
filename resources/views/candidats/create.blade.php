@extends('layouts.app')

@section('title',$title)

@section('css')
@endsection

@section('js')
<script>
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

    $(function() {
        //Animation de l'attente Ajax
        $body = $("body");

        $(document).on({
            ajaxStart: function() { $body.addClass("loading");    },
            ajaxStop: function() { $body.removeClass("loading"); }    
        });

        $('#code_postal')[0].onchange = function(event) { getLocaliteFromCP(this) };
        $('#localite')[0].onchange = function(event) { getCPFromLocalite(this) };
        $('select[name="autres"]').on('change',function(){
            $selected = $(this).find('option:selected')

            if($(this).val()!=0) {
                tValues = $(this).val().split('-');
                id = tValues[0];
                code_langue = tValues[1];
                texte = $selected.text();
                $selected.remove();
                
                tr = '<tr><td style="padding:0 15px"><label for="langue['+code_langue+']">'
                        +texte[0].toUpperCase()+texte.substring(1)+'</td><td>';
                
                for(var i=0;i<=5;i++) {
                    tr += '<input id="langue-'+code_langue+'-'+i+'" name="langue['+code_langue+'|'+id+']" type="radio" value="'+i+'"> \
                        <label for="langue-'+code_langue+'-'+i+'">'+i+'</label>\n';
                }
                
                tr += '</td></tr>';

                $('#tbl-langues tbody').append(tr);
            }
        });

        $('#diplome').on('change',function() {
            var selectedValue = $(this).val().split('|');

            if(selectedValue.length>=2) {
                var diplomeEcoleId = selectedValue[0].trim();
                var diplome  = selectedValue[1].trim();

                //le texte entré fait-il partie des diplomes de la liste ?
                if($('#list-diplomes option[value="'+$(this).val()+'"]').length) {

                    //le diplome est-il déj ajouté?
                    if($ ('#selected-diplomes input[value='+diplomeEcoleId+']').length===0) {
                        diplome = '<p>'+diplome+ 
                        '<input type="hidden" name="diplome_ecole_ids[]" value="'+diplomeEcoleId+'"> \
                        <i class="fa fa-minus-square" onclick="$(this).parent().remove()" style="color:red; cursor:pointer"></i>\n \
                        </p>';
                        
                        //Ajouter le diplome
                        $('#selected-diplomes').append(diplome);
                    
                    }

                    $(this).val('');
                }
            } else {
                alert('Valeur incorrecte, Veuillez sélectionner une valeur dans la liste');
                $(this).val('').focus();
            }
        });

        const APP_URL = '{{ Config::get('app.url') }}'; //console.log(APP_URL+ '/public/api/' + table);
        var armtAPI = APP_URL + '/public/api/';

        $('#designation, #finalite, #niveau').on('change', function() {
                var data = {};
                data['designation'] = $('#designation').val().trim();
                data['finalite']  = $('#finalite').val().trim();
                data['niveau']  = $('#niveau').val().trim();

                if (data['designation']!='' && data['niveau']!='') { 
                    var apiURL = armtAPI+'diplome?designation='+
                        data['designation']+'&finalite='+
                        data['finalite']+'&niveau='+data['niveau'];

                    $.get(apiURL, function(response) {
                        if(response!==false) {
                            $('#code_diplome').val(response.code_diplome);
                            $('#code_diplome').attr('readonly',true);
                        } else {
                            $('#code_diplome').val('');
                            $('#code_diplome').attr('readonly',false);
                        }
                    }).fail(function(error) {
                        $('#code_diplome').val('');
                        alert('Eche de la requête au serveur!')
                        $('#code_diplome').attr('readonly',false);
                    });
                }
        });
        $('#btnAddDiplomeDialog').on('click', function() {
            var apiURL;
            var data = {};
            data['designation'] = $('#designation').val().trim();
            data['finalite']  = $('#finalite').val().trim();
            data['niveau']  = $('#niveau').val().trim();
            data['code_ecole']  = $('#code_ecole').val().trim();
            data['code_diplome']  = $('#code_diplome').val().trim();

            if(data['designation']!='' && data['niveau']!='' && data['code_diplome']!=''){    
                //Ajout du diplome
                apiURL = armtAPI+'diplome';

                $.post(apiURL, data, function(response){
                    if(response) {
                        var diplomeId = response.id;
                        data['diplome_id'] = diplomeId;
                    } 
                }).done(function(response) {
                    if(response) {
                        if(data['code_ecole']!='') {
                            //Ajout de l'ecole
                            apiURL = armtAPI+'ecole';

                            $.post(apiURL, data, function(response) {
                                if(response) {
                                    var ecoleId = response.id;
                                    data['ecole_id'] = ecoleId;
                                }
                            }).done(function(response) {
                                if(response) {
                                    //Ajout de l'association diplome-ecole
                                    apiURL = armtAPI+'diplomes_ecoles';

                                    postDataForDiplomesEcoles(apiURL, data);
                                } else {
                                    handleError('ecole');
                                }
                            }).fail(function() {
                                handleError('ecole(ajax)');
                            });
                        } else {  //Pas d'école spécifiée
                            data['ecole_id'] = null;

                            //Ajout de l'association diplome-ecole
                            apiURL = armtAPI+'diplomes_ecoles';

                            postDataForDiplomesEcoles(apiURL, data);
                        }
                    } else {
                        handleError('diplôme id ');
                    }
                }).fail(function() {
                    handleError('diplomes');
                });
            } else {
                var fields = [];
                if(data['designation']=='') {
                    fields.push('designation');
                } 
                
                if(data['niveau']!='') {
                    fields.push('niveau');
                }

                if(data['code_diplome']!='') {
                    fields.push('code_diplome');
                }

                if(data['designation']!='' && data['niveau']!='' && data['code_diplome']!=''){
                    handleError('Veuillez remplir les champs obligatoires');
                } else {
                    handleError('Veuillez remplir les champs obligatoire ('+fields.join(', ')+')!');
                }
            }
        });


        $('#btnCloseDiplomeDialog').on('click', function(e, mustConfirm = true) {
            if(mustConfirm) {
                var designation = $('#designation').val();
                var finalite = $('#finalite').val();
                var niveau = $('#niveau').val();
                var code_ecole = $('#code_ecole').val();
                var code_diplome = $('#code_diplome').val();

                if(designation=='' && finalite=='' && niveau=='' && code_ecole=='' && code_diplome=='') {
                    $(this).attr('data-dismiss','modal');
                } else {
                    if(confirm('Etes-vous sur de vouloir annuler')) {
                        //Vider le formulaire
                        $('#designation').val('');
                        $('#finalite').val('');
                        $('#niveau').val('');
                        $('#code_ecole').val('');
                        $('#code_diplome').val('');
                        $('#code_diplome').attr('readonly',false);

                        $(this).attr('data-dismiss','modal');
                    } else {
                        $(this).removeAttr('data-dismiss');
                    }
                }
            }
        });

        $('#btnSaveSocieteDialog').on('click', function() {
        /*
            var nbSocCans = $('#tbl-societes tbody tr').length;

            var $rows = $('#tbl-societes tbody tr[data-id]');
            var socCanIds = [];
           
            $rows.each(function(i, row){
                socCanIds.push($('<input>', {
                    name:"socCan[socCanIds][]",
                    value : $(row).data('id'),
                })[0]);
            });
            
            var $societeIds = $('input [name="socCan[societeIds][]"]');
            var $fonctionIds = $('input [name="socCan[fonctionIds][]"]');
            var $dateDebuts = $('input [name="socCan[dateDebuts][]"]');
            var $dateFins = $('input [name="socCan[dateFins][]"]');

            var idCandidat = $('#candidat_id').text();

            data = socCanIds;
            $.merge(data, $societeIds);
            $.merge(data, $fonctionIds);
            $.merge(data, $dataDebuts);
            $.merge(data, $dateFins);
            $.ajax({
                url : armtAPI+'jobs/'+idCandidat,
                type : 'PUT',
                data : data,
            }).done(function(data) {
            }).fail(function(error) {
                //Flash message
                alert('Erreur lors de la modification');
            });
        */

            //Actualiser derniere societe et fonction
            updateActualSociety();
        });

        $('#btnAddSociete').on('click',function() {
            var error = false;
            var societeId, societe, fonctionId, fonction;
            var selectedValue = $('#societe').val().split('|');
            
            if(selectedValue[1]!=undefined) {
                societeId = selectedValue[0] ? selectedValue[0].trim():'';
                societe = selectedValue[1] ? selectedValue[1].trim():'';
            } else { //Ajout d'une nouvelle société
                societeId = selectedValue[0] ? selectedValue[0].trim():'';
                societe = selectedValue[0] ? selectedValue[0].trim():'';

                if(societe=='') {
                    alert('Veuillez entrer une société!')
                    return;
                }


                //Ajout de la société
                apiURL = armtAPI+'societe';

                $.post(apiURL, {nom_entreprise:societe}, function(response){
                    societeId = response.id;
                    var inputValue = response.id+' | '+response.nom_entreprise;
                    var inputText = response.id+' | '+response.nom_entreprise;

                    //Update datalist (if not already in the list)
                    if($('#list-societes option').filter('[value="'+inputValue+'"]').length==0) {
                        //Make new value & text
                        var datalistOption = $('<option></option>');
                        datalistOption.attr('value',inputValue);
                        datalistOption.text(inputText);

                        $('#list-societes').append(datalistOption);
                    }

                    //Put Value then Trigger input
                    $('#societe').val('')
                }).fail(function() {
                    error = true;
                    handleError('société (Ajax)');
                });
            }
           
            selectedValue = $('#fonction').val().split('|');
            
            if(selectedValue[1]!=undefined) {
                fonctionId = selectedValue[0] ? selectedValue[0].trim():'';
                fonction = selectedValue[1] ? selectedValue[1].trim():'';
            } else { //Ajout d'une nouvelle fonction
                fonctionId = selectedValue[0] ? selectedValue[0].trim():'';
                fonction = selectedValue[0] ? selectedValue[0].trim():'';

                if(societe!='recherche d\'emploi' && fonction=='') {
                    alert('Veuillez entrer une fonction!')
                    return;
                }

                if(fonction !='') {
                    //Ajout de la fonction
                    apiURL = armtAPI+'fonction';

                    $.post(apiURL, {fonction:fonction}, function(response){
                        fonctionId = response.id;
                        var inputValue = response.id+' | '+response.fonction;
                        var inputText = response.id+' | '+response.fonction;

                        //Update datalist (if not already in the list)
                        if($('#list-fonctions option').filter('[value="'+inputValue+'"]').length==0) {
                            //Make new value & text
                            var datalistOption = $('<option></option>');
                            datalistOption.attr('value',inputValue);
                            datalistOption.text(inputText);

                            $('#list-fonctions').append(datalistOption);
                        }

                        //Put Value then Trigger input
                        $('#fonction').val('')
                    }).fail(function(){
                        error = true
                        handleError('fonction (Ajax)');
                    });
                }
            }

            var date_debut = $('#date_debut').val();
            var date_fin = $('#date_fin').val();

            if(!error) {
                
                var data = {};
                data.societeId = societeId;
                data.societe = societe;
                data.fonctionId = fonctionId;
                data.fonction = fonction;
                data.date_debut = date_debut;
                data.date_fin = date_fin;
                
                //Ajouter l'emploi dans le tableau
                prependTableRow(data);

                //Actualiser derniere societe et fonction
                updateActualSociety();
            }
        });
    });

    function handleError(source) {
                alert('Echec de la requête au serveur(ajout '+source+')!')
    }

    function prependTableRow(data) {
        $('#tbl-societes tbody tr:visible:first').toggleClass('danger');
                
            var row = '<tr scope="row" class="danger" data-id=""> \
                <td>*\n\
                    <input type="hidden" name="socCan[socCanIds][]" value="">\n\
                </td>\n\
                <td>'+data.societe+'\n\
                    <input type="hidden" name="socCan[societeIds][]" value="'+data.societeId+'">\n\
                </td>\n\
                <td>'+data.fonction+'\n\
                    <input type="hidden" name="socCan[fonctionIds][]" value="'+data.fonctionId+'">\n\
                </td>\n\
                <td>'+data.date_debut+' \
                    <input type="hidden" name="socCan[dateDebuts][]" value="'+data.date_debut+'">\n\
                </td> \
                <td>'+data.date_fin+' \
                    <input type="hidden" name="socCan[dateFins][]" value="'+data.date_fin+'">\n\
                </td> \
                <td><i class="fa fa-minus-square" onclick="removeTableRow(this)" style="cursor:pointer" style="color:red"><i></td> \
            </tr>';

            $('#tbl-societes tbody').prepend(row);

            $('#societe').val('');
            $('#fonction').val('');
            $('#date_debut').val('');
            $('#date_fin').val('');
    }

    function removeTableRow(btn) {
        var $tbody = $(btn).parentsUntil('tbody').parent('tbody');

        //Marquer la ligne comme supprimée
        var $tr = $(btn).parentsUntil('tr').parent();
        $tr.find('td:first input').attr('name','socCan[deletedIds][]');
        
        //retirer la ligne du tableau
        $tr.hide();

        //Mettre la premiere ligne du tableau en surbrillance
        $tbody.find('tr:visible:first').addClass('danger');

        //Actualiser derniere societe et fonction
        updateActualSociety();
       
    }

    function updateActualSociety() {
        //Actualiser derniere société et fonction
        $actualSocietyData = $('#tbl-societes tbody tr:visible:first');
        $actualSociety = $actualSocietyData.find('td:nth-child(2)').text().trim();
        $lastFunction = $actualSocietyData.find('td:nth-child(3)').text().trim();

        if($lastFunction =='') {
            $trs = $actualSocietyData.siblings();
            for(var i=0;i<$trs.length;i++) {
                var previousFunction = $($trs[i]).find('td:nth-child(3)').text();
                if($($trs[i]).text() !='') {
                    $lastFunction = previousFunction;
                    break;
                }
            }
        }

        $('#actualSociety span').html($actualSociety);
        $('#lastFunction span').html($lastFunction);
    }

    function postDataForDiplomesEcoles(apiURL, data) {
        $.post(apiURL, data, function(response) {
            if(response) {
                var diplomeEcoleId = response.id;
                data['diplomeEcole_id'] = diplomeEcoleId;

                //Prepare new value & text
                var inputValue = data['diplomeEcole_id']+' | '+ data['designation']+' ('+
                    data['niveau']+' '+data['finalite']+') - '+ 
                    (data['code_ecole'] ? data['code_ecole']:'');
                var inputText = data['code_diplome']+' | '+data['diplome_id'];
                

                //Update datalist (if not already in the list)
                if($('#list-diplomes option').filter('[value="'+inputValue+'"]').length==0) {
                    //Make new value & text
                    var datalistOption = $('<option></option>');
                    datalistOption.attr('value',inputValue);
                    datalistOption.text(inputText);

                    $('#list-diplomes').append(datalistOption);
                }

                //Put Value then Trigger input
                $('#diplome').val(inputValue).trigger('change');

                //Empty dialog box
                $('#designation').val('');
                $('#finalite').val('');
                $('#niveau').val('');
                $('#code_ecole').val('');
                $('#code_diplome').val('');

                //Close the dialog box (false means no verification)
                $('#btnCloseDiplomeDialog').trigger('click',[false]);
            } else { 
                handleError('association diplome-ecoles');
            }
        }).fail(function() {
            handleError('association diplome-ecoles(ajax)');
        });
    }

    function valider(frm, fields) {
        for(var i=0; i<fields.length;i++) {
            $field = $('[name='+fields[i]+']');

            if($field.length==1){
                if($field.val().trim()=='') {
                    //Message + focus
                    alert('Veuillez remplir le champ'+fields[i]+'!');
                    $field.focus();

                    return false;
                }
             } else {
                for(var j=0;j<$field.length;j++) {
                    if($field[j].checked()) {
                        continue;
                    }
                }

                return false;
            }
        }
        return true;
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
                                'role'=>'form',
                                'enctype'=>'multipart/form-data',
                                /*'onsubmit' => 'return valider(this,[nom,prenom,sexe,email])'*/
                            ]) }}
                            <div class="row">
                                <div class="col-lg-6">
                                    <div style="display:none" id="candidat_id">{{isset($candidat) ? $candidat->id:''}}</div>
                                    <div class="form-group">
                                        {{ Form::label('nom','Nom :')}}
                                        {{ Form::text('nom',
                                            old('nom')?? (isset($candidat) ? $candidat->nom:''),
                                            [
                                            'placeholder'=>'ex: Croisy',
                                            'class'=>'form-control'
                                        ]) }}
                                    </div>

                                    <div class="form-group">
                                        {{ Form::label('prenom','Prénom:')}}
                                        {{ Form::text('prenom',
                                            old('prenom')?? (isset($candidat) ? $candidat->prenom:''),
                                            [
                                            'placeholder'=>'ex: Eric',
                                            'class'=>'form-control'
                                        ]) }}
                                    </div>

                                    <div class="form-group">
                                        {{ Form::label('date_naissance','Date de naissance:')}}
                                        {{ Form::date('date_naissance',
                                            old('date_naissance')?? (isset($candidat) ? $candidat->date_naissance:''),
                                            [
                                            'placeholder'=>'ex: 16/11/1992 ',
                                            'class'=>'form-control'
                                        ]) }}
                                    </div>

                                    <div class="form-group">
                                        {{ Form::label('sexe','Sexe:')}}
                                        {{ Form::radio('sexe','m',
                                            old('sexe')=='m'|| (isset($candidat) && $candidat->sexe=='m'),
                                            [
                                            'id'=>'sexe-m',
                                        ])}}
                                        {{ Form::label('sexe-m','M')}}
                                        {{ Form::radio('sexe','f',
                                            old('sexe')=='f'|| (isset($candidat) && $candidat->sexe=='f'),
                                            [
                                            'id'=>'sexe-f',
                                        ])}}
                                        {{ Form::label('sexe-f','F')}} 
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
                                        {{ Form::label('langues','Langues:')}}
                                        <p>(0=>langue inconnue | 1=>connais quelques mot | 2=>Notion | 3=>se debrouille | 4=>bilingue | 5=>langue maternelle)<p>
                                        <table id="tbl-langues">
                                            <tfoot>
                                                <tr>
                                                    <td colspan="2" style="padding:0 15px">
                                                        {{ Form::select('autres',
                                                            $autresLangues,
                                                            [
                                                                'class'=>'form-control'
                                                        ]) }}
                                                    </td>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                            @foreach($showLangues as $langue)
                                            <tr>
                                                <td style="padding:0 15px">
                                                    {{ Form::label('langue-'.$langue->code_langue,ucfirst($langue->designation))}}
                                                </td>
                                                <td>
                                                    <input id="langue-{{$langue->code_langue}}-0" name="langue[{{ $langue->code_langue.'|'.$langue->id}}]" 
                                                           type="radio" value="0" {{ (isset($langue->pivot) && $langue->pivot->niveau==0)? 'checked': ''}}>
                                                    <label for="langue-{{$langue->code_langue}}-0">0</label>
                                                    @for($i=1;$i<=5;$i++)
                                                    {{ Form::radio('langue['.$langue->code_langue.'|'.$langue->id.']',
                                                        $i, //value
                                                        (isset($langue->pivot) && $langue->pivot->niveau==$i)?true:false, //checked
                                                        [
                                                            'id'=>'langue-'.$langue->code_langue.'-'.$i,
                                                        ]) 
                                                    }} {{ Form::label('langue-'.$langue->code_langue.'-'.$i,$i)}}
                                                    @endfor
                                                </td>
                                            </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>           


                                    <div class="form-group">
                                        {{ Form::label('diplomes','Diplôme:')}} <i class="fa fa-plus-square" data-toggle="modal" data-target="#addDiplomeModal"  style="color:blue; font-size:1.7em; cursor: pointer"></i>
                                        {{ Form::text('diplome',
                                            old('diplome')?? '',
                                            [
                                                'placeholder'=>'ex: Ingénieur industriel (master informatique) - ECAM',
                                                'class'=>'form-control',
                                                'id'=>'diplome',
                                                'list'=>'list-diplomes'
                                        ]) }}
                                        <datalist id="list-diplomes">
                                            @foreach($diplomeEcoles as $de)
                                                <option value="{{ $de->id}} | {{ $de->diplome['designation']}} ({{$de->diplome['niveau']}} {{$de->diplome['finalite']}}) - {{isset($de->ecole) ? $de->ecole['code_ecole']:''}}">{{$de->diplome['code_diplome']}} | {{$de->diplome_id}}</option>
                                            @endforeach
                                        </datalist>
                                        <div id="selected-diplomes" style="margin:15px">
                                        @if(isset($candidat))
                                                @foreach($candidatDiplomeEcoles as $cde)
                                                    <p>
                                                        {{ $cde->designation.' '.'('.$cde->niveau.' '.$cde->finalite.')'.' '.'-'.' '.($cde->code_ecole ?? '') }}
                                                        <input type="hidden" name="diplome_ecole_ids[]" value="{{$cde->de_id}}"> 
                                                        <i class="fa fa-minus-square" onclick="$(this).parent().remove()" style="color:red; cursor:pointer"></i>
                                                    </p>
                                                @endforeach()        
                                        @endif
                                        </div>
                                        
                                        <!-- Formulaire d'ajout d'un nouveau diplômes -->
                                        <div class="modal fade" id="addDiplomeModal" tabindex="-1" role="dialog" aria-labelledby="addDiplomeModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="addDiplomeModalLabel"><strong>Nouveau diplôme</strong></h5>
                                                    <p><span style="color:red; font-size:25px;">*</span>Champs obligatoire<p>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form>
                                                        <div class="form-group">
                                                            <label for="designation" class="col-form-label">Désignation:<span style="color:red; font-size:25px;">*<span></label>
                                                            <input type="text" data-required="true" class="form-control" id="designation" list="list-designations">
                                                            <datalist id="list-designations">
                                                            @foreach($designations as $designation)
                                                                <option value="{{ $designation}}">{{ $designation }}</option>
                                                            @endforeach
                                                            </datalist>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="finalite" class="col-form-label">Finalité:</label>
                                                            <input type="text" class="form-control" id="finalite" list="list-finalites">
                                                            <datalist id="list-finalites">
                                                            @foreach($finalites as $finalite)
                                                                <option value="{{ $finalite}}">{{ $finalite }}</option>
                                                            @endforeach
                                                            </datalist>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="niveau" class="col-form-label">Niveau:<span style="color:red; font-size:25px;">*<span></label>
                                                            <input type="text" data-required="true" class="form-control" id="niveau" list="list-niveaux">
                                                            <datalist id="list-niveaux">
                                                            @foreach($niveaux as $niveau)
                                                                <option value="{{$niveau}}">{{ $niveau }}</option>
                                                            @endforeach
                                                            </datalist>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="code_ecole" class="col-form-label">Ecole:</label>
                                                            <input type="text" class="form-control" id="code_ecole" name="code_ecole" list="list-ecoles">
                                                            <datalist id="list-ecoles">
                                                            @foreach($ecoles as $ecole)
                                                                <option value="{{ $ecole->code_ecole}}">{{ $ecole->code_ecole }}</option>
                                                            @endforeach
                                                            </datalist>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="code_diplome" class="col-form-label">Code Diplôme:<span style="color:red; font-size:25px;">*<span></label>
                                                            <input type="text" class="form-control" id="code_diplome">
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" id="btnCloseDiplomeDialog" data-dismiss="modal">Fermer</button>
                                                    <button type="button" class="btn btn-primary" id="btnAddDiplomeDialog">Ajouter</button>
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <fieldset><legend>Employeurs</legend>
                                            <div class="form-group">
                                                <p id="actualSociety"><strong>Dernier Employeur :</strong> <span>{{$actualSociety}}</span></p>
                                                <p id="lastFunction"><strong>Dernière Fonction exercée:</strong> <span>{{$lastFunction}}</span></p>
                                            </div>

                                            <span class="btn btn-success" data-toggle="modal" data-target="#addSocieteModal"  style="color:white;">Gérer les employeurs</span>
                                            <!-- Formulaire d'ajout d'un nouvelle societe -->
                                            <div class="modal fade" id="addSocieteModal" tabindex="-1" role="dialog" aria-labelledby="addSocieteModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                        <h5 class="modal-title" id="addSocieteModalLabel" style="font-size:1.5em" >Gestion des employeurs antérieurs & actuels</h5>
                                                        <p>Veuillez ajouter chaque employeur en terminant par la dernièr employeur et/ou fonction du candidat</p>
                                                    </div>
                                                    <div class="modal-body">
                                                        <table class="table table-striped" id="tbl-societes">
                                                            <thead>
                                                                <tr>
                                                                    <th>Id</th><th>Employeur</th><th>Fonction exercée</th><th>Date début</th><th>Date fin</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            @if($societeCandidat = $societeCandidats->first())
                                                                <tr scope="row" class="danger" data-id="{{$societeCandidat->id}}">
                                                                    <td>{{$societeCandidat->id}}
                                                                        <input type="hidden" name="socCan[socCanIds][]" value="{{$societeCandidat->id}}">
                                                                    </td>
                                                                    <td>{{$societeCandidat->societe->nom_entreprise}}
                                                                        <input type="hidden" name="socCan[societeIds][]" value="{{$societeCandidat->societe->id}}">
                                                                    </td>
                                                                    <td>{{$societeCandidat->fonction->fonction ?? ''}}
                                                                        <input type="hidden" name="socCan[fonctionIds][]" value="{{$societeCandidat->fonction->id ?? ''}}">
                                                                    </td>
                                                                    <td>{{$societeCandidat->date_debut}}
                                                                        <input type="hidden" name="socCan[dateDebuts][]" value="{{$societeCandidat->date_debut}}">
                                                                    </td>
                                                                    <td>{{$societeCandidat->date_fin}}
                                                                        <input type="hidden" name="socCan[dateFins][]" value="{{$societeCandidat->date_fin}}">
                                                                    </td>
                                                                    <td>
                                                                        <i class="fa fa-minus-square" onclick="removeTableRow(this)" style="cursor:pointer" style="color:red"></i>
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                            @foreach($societeCandidats->slice(1) as $societeCandidat)
                                                                <tr scope="row" data-id="{{$societeCandidat->id}}">
                                                                    <td>{{$societeCandidat->id}}
                                                                        <input type="hidden" name="socCan[socCanIds][]" value="{{$societeCandidat->id}}">
                                                                    </td>
                                                                    <td>{{$societeCandidat->societe->nom_entreprise}}
                                                                        <input type="hidden" name="socCan[societeIds][]" value="{{$societeCandidat->societe->id}}">
                                                                    </td>
                                                                    <td>{{$societeCandidat->fonction->fonction ?? ''}}
                                                                        <input type="hidden" name="socCan[fonctionIds][]" value="{{$societeCandidat->fonction->id ?? ''}}">
                                                                    </td>
                                                                    <td>{{$societeCandidat->date_debut}}
                                                                        <input type="hidden" name="socCan[dateDebuts][]" value="{{$societeCandidat->date_debut}}">
                                                                    </td>
                                                                    <td>{{$societeCandidat->date_fin}}
                                                                        <input type="hidden" name="socCan[dateFins][]" value="{{$societeCandidat->date_fin}}">
                                                                    </td>
                                                                    <td>
                                                                        <i class="fa fa-minus-square" onclick="removeTableRow(this)" style="cursor:pointer" style="color:red"></i>
                                                                    </td>
                                                                </tr>                                                         
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                        <form>
                                                            <div class="form-group">
                                                                <label for="recipient-name" class="col-form-label">Employeur:</label>
                                                                <input type="text" class="form-control" id="societe" list="list-societes">
                                                                <datalist id="list-societes">
                                                                @foreach($societes as $societe)
                                                                    <option value="{{ $societe->id }} | {{ $societe->nom_entreprise}}">{{ $societe->id }}</option>
                                                                @endforeach
                                                                </datalist>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="recipient-name" class="col-form-label">Fonction exercée:</label>
                                                                <input type="text" class="form-control" id="fonction" list="list-fonctions">
                                                                <datalist id="list-fonctions">
                                                                @foreach($fonctions as $fonction)
                                                                    <option value="{{ $fonction->id}} |{{ $fonction->fonction}}">{{ $fonction->id }}</option>
                                                                @endforeach
                                                                </datalist>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="recipient-name" class="col-form-label">Date début:</label>
                                                                <input type="date" class="form-control" id="date_debut">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="message-text" class="col-form-label">Date fin:</label>
                                                                <input type="date" class="form-control" id="date_fin">
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <div class="row">
                                                            <div class="col-lg-8 col-sm-8">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="if(!confirm('Etes vous sur de vouloir annuler ?')) { $(this).removeAttr('data-dismiss'); } else { $(this).attr('data-dismiss','modal'); }">Annuler les modifications</button>
                                                                <button type="button" class="btn btn-primary" data-dismiss="modal" id="btnSaveSocieteDialog">Sauvegarder & fermer</button>
                                                            </div> 
                                                            <div class="col-lg-4 col-sm-4">
                                                                <!-- Ajax waiting animation -->                          
                                                                <div class="waiting"></div>

                                                                <button type="button" class="btn btn-success" id="btnAddSociete">Ajouter</button>   
                                                            </div>
                                                        </div>
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>  
                                    </div>         
                                </div>
                                

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::hidden('localite_id',
                                            old('localite')?? (isset($candidat) ? $candidat->localite_id:''),
                                            [
                                                'id'=>'localite_id',
                                        ]) }}
                                        <div class="row">
                                            <div class="col-lg-4 col-xs-4">
                                                {{ Form::label('code_postal','Code postal:') }}
                                                {{ Form::text('code_postal',
                                                old('code_postal')?? (isset($candidat) ? $candidat->localite->code_postal : ''),
                                                [
                                                    'placeholder' => 'ex.: 1400',
                                                    'class' => 'form-control',
                                                ]) }}
                                            </div>
                                            <div class="col-lg-8 col-xs-8">
                                                {{ Form::label('localite','Localité:') }}
                                                {{ Form::text('localite',
                                                old('localite')?? (isset($candidat) ? $candidat->localite->localite : ''),
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
                                        {{ Form::label('Email','Email:')}}
                                        <div class="form-group input-group">
                                            <span class="input-group-addon">@</span>
                                            {{ Form::email('email',
                                                old('email')?? (isset($candidat) ? $candidat->email:''),
                                                [
                                                'placeholder'=>'mail@example.com',
                                                'class'=>'form-control'
                                            ]) }}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        {{ Form::label('linkedin','LinkedIn:')}}
                                        {{ Form::url('linkedin',
                                            old('linkedin')?? (isset($candidat) ? $candidat->linkedin:''),
                                            [
                                            'placeholder'=>'ex: https://www.linkedin.com/in/example',
                                            'class'=>'form-control'
                                        ]) }}
                                    </div>
                                    <div class="form-group">
                                        {{ Form::label('site','Site internet:')}}
                                        {{ Form::url('site',
                                            old('site')?? (isset($candidat) ? $candidat->site:''),
                                            [
                                            'placeholder'=>'ex: https://www.advaconsult.com',
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
                                    {{ Form::submit('Enregistrer',[
                                        'class'=>'btn btn-primary pull-right',
                                    ]) }}
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
