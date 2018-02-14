@extends('layouts.app')

@section('title',$title)

@section('css')
@endsection

@section('js')
<script>
    //$('#date-creation input').datepicker({
        //weekStart: 1,
        //todayBtn: "linked",
        //language: "fr",
        //multidateSeparator: "."
    //});

    $(function() {
        $('select[name="autres"]').on('change',function(){
            $selected = $(this).find('option:selected')

            if($(this).val()!=0) {
                tValues = $(this).val().split('-');
                id = tValues[0];
                code_langue = tValues[1];
                texte = $selected.text();
                $selected.remove();
                
                tr = '<tr><td style="padding:0 15px"><label for="langue-'+code_langue+'">'
                        +texte[0].toUpperCase()+texte.substring(1)+'</td><td>';
                
                for(var i=0;i<=5;i++) {
                    tr += '<input id="langue-'+i+'" name="langue-'+code_langue+'" type="radio" value="'+i+'"> \
                        <label for="langue-'+i+'">'+i+'</label>\n';
                }
                
                tr += '</td></tr>';

                $('#tbl-langues tbody').append(tr);
            }
        });

        $('#diplome').on('input',function() {
            var diplome  = $(this).val();

            //le texte entré fait-il partie des diplomes de la liste ?
            if($('#list-diplomes option[value="'+diplome+'"]').length) {

                //le diplome est-il déj ajouté?
                if($ ('#selected-diplomes:contains("'+diplome+'")').length==0) {
                    diplome = '<p>'+diplome+' <i class="fa fa-minus-square" onclick="$(this).parent().remove()" style="color:red; cursor:pointer"></i></p>';
                    
                    $('#selected-diplomes').append(diplome);
                   
                }

                $(this).val('');
            }
        });

        $('#btnSaveSocieteDialog').on('click', function() {
            $actualSocietyData = $('#tbl-societes tbody tr:first');
            $actualSociety = $actualSocietyData.find('td:nth-child(1)').text().trim();
            $lastFunction = $actualSocietyData.find('td:nth-child(2)').text().trim();

            if($lastFunction =='') {
                $trs = $actualSocietyData.siblings();
                for(var i=0;i<$trs.length;i++) {
                    var previousFunction = $($trs[i]).find('td:nth-child(2)').text();
                    if($($trs[i]).text() !='') {
                        $lastFunction = previousFunction;
                        break;
                    }
                }
            }

            $('#actualSociety span').html($actualSociety);
            $('#lastFunction span').html($lastFunction);
        });

        $('#btnAddSociete').on('click',function() {
            var societe = $('#societe').val();
            var fonction = $('#fonction').val();
            var date_debut = $('#date_debut').val();
            var date_fin = $('#date_fin').val();

            if(societe.trim()=='') {
                alert('Veuillez entrer une société.');
                return;
            }

            $('#tbl-societes tbody tr:first').toggleClass('danger');
            var row = '<tr scope="row" class="danger"> \
                 <td>'+societe+'</td><td>'+fonction+'</td> \
                 <td>'+date_debut+'</td><td>'+date_fin+'</td> \
                 <td><i class="fa fa-minus-square" onclick="removeTableRow(this)" style="cursor:pointer" style="color:red"><i></td> \
            </tr>';

            $('#tbl-societes tbody').prepend(row);

            $('#societe').val('');
            $('#fonction').val('');
            $('#date_debut').val('');
            $('#date_fin').val('');
        });
    });

    function removeTableRow(btn) {
        var $tbody = $(btn).parentsUntil('tbody').parent('tbody');

        //retirer la ligne du tableau
        $(btn).parentsUntil('tr').parent().remove();

        //Mettre la premiere ligne du tableau en surbrillance
        $tbody.find('tr:first').addClass('danger');
       
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
                            <div class="row">
                                <div class="col-lg-6">
                                    {{Form::open([
                                        'route'=>$route,
                                        'method'=>$method,
                                        'role'=>'form'
                                    ]) }}
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
                                        <table id="tbl-langues">
                                            <tfoot>
                                                <tr>
                                                    <td colspan="2" style="padding:0 15px">
                                                        {{ Form::select('autres',
                                                            $langues,
                                                            [
                                                                'class'=>'form-control'
                                                        ]) }}
                                                    </td>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                            @foreach($bestLangues as $langue)
                                            <tr>
                                                <td style="padding:0 15px">
                                                    {{ Form::label('langue-'.$langue->code_langue,ucfirst($langue->designation))}}
                                                </td>
                                                <td>
                                                    <input id="langue-0" name="{{ 'langue-'.$langue->code_langue }}" type="radio" value="0">
                                                    <label for="langue-0">0</label>
                                                    @for($i=1;$i<=5;$i++)
                                                    {{ Form::radio('langue-'.$langue->code_langue,$i,
                                                        null,//old('langue')==$langue->designation || (isset($candidat) && $candidat->sexe=='m'),
                                                        [
                                                            'id'=>'langue-'.$i,
                                                        ]) 
                                                    }} {{ Form::label('langue-'.$i,$i)}}
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
                                            old('diplome')?? (isset($candidat) ? $candidat->diplome:''),
                                            [
                                                'placeholder'=>'ex: Bachelier',
                                                'class'=>'form-control',
                                                'id'=>'diplome',
                                                'list'=>'list-diplomes'
                                        ]) }}
                                        <datalist id="list-diplomes">
                                        @foreach($diplomes as $diplome)
                                            <option value="{{ $diplome->designation}} ({{$diplome->niveau}} {{$diplome->finalite}}) - {{$diplome->ecoles->first()->code_ecole}}">{{$diplome->code_diplome}}}</option>
                                        @endforeach
                                        </datalist>
                                        <div id="selected-diplomes" style="margin:15px">
                                        </div>
                                        
                                        <!-- Formulaire d'ajout d'un nouveau diplômes -->
                                        <div class="modal fade" id="addDiplomeModal" tabindex="-1" role="dialog" aria-labelledby="addDiplomeModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="addDiplomeModalLabel">Nouveau diplôme</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form>
                                                        <div class="form-group">
                                                            <label for="recipient-name" class="col-form-label">Désignation:</label>
                                                            <input type="text" class="form-control" id="recipient-name" list="list-designations">
                                                            <datalist id="list-designations">
                                                            @foreach($designations as $designation)
                                                                <option value="{{ $designation}}">{{ $designation }}</option>
                                                            @endforeach
                                                            </datalist>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="recipient-name" class="col-form-label">Finalité:</label>
                                                            <input type="text" class="form-control" id="recipient-name" list="list-finalites">
                                                            <datalist id="list-finalites">
                                                            @foreach($finalites as $finalite)
                                                                <option value="{{ $finalite}}">{{ $finalite }}</option>
                                                            @endforeach
                                                            </datalist>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="recipient-name" class="col-form-label">Niveau:</label>
                                                            <input type="text" class="form-control" id="recipient-name" list="list-niveaux">
                                                            <datalist id="list-niveaux">
                                                            @foreach($niveaux as $niveau)
                                                                <option value="{{$niveau}}">{{ $niveau }}</option>
                                                            @endforeach
                                                            </datalist>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="message-text" class="col-form-label">Ecole:</label>
                                                            <input type="text" class="form-control" id="recipient-name" list="list-ecoles">
                                                            <datalist id="list-ecoles">
                                                            @foreach($ecoles as $ecole)
                                                                <option value="{{ $ecole->nom}}">{{ $ecole->code_ecole }}</option>
                                                            @endforeach
                                                            </datalist>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="recipient-name" class="col-form-label">Code Diplôme:</label>
                                                            <input type="text" class="form-control" id="recipient-name">
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                                                    <button type="button" class="btn btn-primary">Ajouter</button>
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <fieldset><legend>Sociétés</legend>
                                            <div class="form-group">
                                                <p id="actualSociety"><strong>Société actuelle/précédente:</strong> <span>{{$actualSociety}}</span></p>
                                                <p id="lastFunction"><strong>Fonction exercée:</strong> <span>{{$lastFunction}}</span></p>
                                            </div>

                                            <button class="btn btn-success" data-toggle="modal" data-target="#addSocieteModal"  style="color:white;">Gérer les sociétés</button>
                                            <!-- Formulaire d'ajout d'un nouvelle societe -->
                                            <div class="modal fade" id="addSocieteModal" tabindex="-1" role="dialog" aria-labelledby="addSocieteModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                        <h5 class="modal-title" id="addSocieteModalLabel" style="font-size:1.5em" >Gestion des sociétés antérieurs & actuelles</h5>
                                                        <p>Veuillez ajouter chaque société en terminant par la dernière société et/ou fonction du candidat</p>
                                                    </div>
                                                    <div class="modal-body">
                                                        <table class="table table-striped" id="tbl-societes">
                                                            <thead>
                                                                <tr>
                                                                    <th>Société</th><th>Fonction exercée</th><th>Date début</th><th>Date fin</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            @if($societeCandidat = $societeCandidats->first())
                                                                <tr scope="row" class="danger">
                                                                    <td>{{$societeCandidat->societe->nom_entreprise}}</td><td>{{$societeCandidat->fonction->fonction ?? ''}}</td><td>{{$societeCandidat->date_debut}}</td><td>{{$societeCandidat->date_fin}}</td>
                                                                    <td><i class="fa fa-minus-square" onclick="removeTableRow($this)" style="cursor:pointer" style="color:red"></i></td>
                                                                </tr>
                                                            @endif
                                                            @foreach($societeCandidats->slice(1) as $societeCandidat)
                                                                <tr scope="row">
                                                                    <td>{{$societeCandidat->societe->nom_entreprise}}</td><td>{{$societeCandidat->fonction->fonction ?? ''}}</td><td>{{$societeCandidat->date_debut}}</td><td>{{$societeCandidat->date_fin}}</td>
                                                                    <td><i class="fa fa-minus-square"  onclick="removeTableRow($this)" style="cursor:pointer" style="color:red"></i></td>
                                                                </tr>
                                                            
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                        <form>
                                                            <div class="form-group">
                                                                <label for="recipient-name" class="col-form-label">Société:</label>
                                                                <input type="text" class="form-control" id="societe" list="list-societes">
                                                                <datalist id="list-societes">
                                                                @foreach($societes as $societe)
                                                                    <option value="{{ $societe->nom_entreprise}}">{{ $societe->id }}</option>
                                                                @endforeach
                                                                </datalist>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="recipient-name" class="col-form-label">Fonction exercée:</label>
                                                                <input type="text" class="form-control" id="fonction" list="list-fonctions">
                                                                <datalist id="list-fonctions">
                                                                @foreach($fonctions as $fonction)
                                                                    <option value="{{ $fonction->fonction}}">{{ $fonction->fonction_id }}</option>
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
