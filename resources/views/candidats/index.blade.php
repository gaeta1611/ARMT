@extends('layouts.app')

@section('title','Liste des candidats')

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
            responsive: true
        });
    });
</script>
@endsection

@include('includes.sidebar')

@section('content')
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Liste des candidats</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                        {{Form::open([
                            'route'=>['candidats.search'],
                            'method'=>'GET',
                            'role'=>'form',
                            'id' =>'frmSearchCandidat'
                        ]) }}
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    {{ Form::label('age','Age :',[ 
                                        'class'=>'col-form-label',
                                    ]) }}
                                    <div class="input-group">
                                        <span class="input-group-addon" id="age-addon">+ de</span>
                                        {{ Form::number('age',null,[ 
                                            'class'=>'form-control',
                                            'id'=>'age',
                                            'aria-describedby'=>'age-addon'
                                        ]) }}

                                    </div>
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
                                        <td nowrap>
                                            @for($i=0;$i<=5;$i++)
                                            {{ Form::radio('langue['.$langue->code_langue.'|'.$langue->id.']',
                                                $i, //value
                                                (isset($langue->pivot) && $langue->pivot->niveau==$i)?true:false, //checked
                                                [
                                                    'id'=>'langue-'.$langue->code_langue.'-'.$i,
                                                ]) 
                                            }} {{ Form::label('langue-'.$langue->code_langue.'-'.$i," $i")}}
                                            {{--Form::label bug with 0 value => [space]0 to fix it --}}
                                            @endfor
                                        </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    {{ Form::label('designation','Désignation :',[ 
                                        'class'=>'col-form-label',
                                    ]) }}
                                    {{ Form::text('designation',null,[ 
                                        'class'=>'form-control',
                                        'id'=>'designation',
                                        'list'=>'list-designations'
                                    ]) }}
                                    <datalist id="list-designations">
                                    @foreach($designations as $designation)
                                        <option value="{{ $designation}}">{{ $designation }}</option>
                                    @endforeach
                                    </datalist>
                                </div>
                                <div class="form-group">
                                    {{ Form::label('finalite','Finalité :',[ 
                                        'class'=>'col-form-label',
                                    ]) }}
                                    {{ Form::text('finalite',null,[ 
                                        'class'=>'form-control',
                                        'id'=>'finalite',
                                        'list'=>'list-finalites'
                                    ]) }}
                                    <datalist id="list-finalites">
                                    @foreach($finalites as $finalite)
                                        <option value="{{ $finalite}}">{{ $finalite }}</option>
                                    @endforeach
                                    </datalist>
                                </div>
                                <div class="form-group">
                                    {{ Form::label('niveau','Niveau :',[ 
                                        'class'=>'col-form-label',
                                    ]) }}
                                    {{ Form::text('niveau',null,[ 
                                        'class'=>'form-control',
                                        'id'=>'niveau',
                                        'list'=>'list-niveaux'
                                    ]) }}
                                    <datalist id="list-niveaux">
                                    @foreach($niveaux as $niveau)
                                        <option value="{{$niveau}}">{{ $niveau }}</option>
                                    @endforeach
                                    </datalist>
                                </div>
                                <div class="form-group">
                                    {{ Form::label('ecole','Ecole :',[ 
                                        'class'=>'col-form-label',
                                    ]) }}
                                    {{ Form::text('ecole',null,[ 
                                        'class'=>'form-control',
                                        'id'=>'ecole',
                                        'list'=>'list-ecoles'
                                    ]) }}
                                    <datalist id="list-ecoles">
                                    @foreach($ecoles as $ecole)
                                        <option value="{{ $ecole->nom}}">{{ $ecole->code_ecole }}</option>
                                    @endforeach
                                    </datalist>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    {{ Form::label('societe','Employeur :',[ 
                                        'class'=>'col-form-label',
                                    ]) }}
                                    {{ Form::text('societe',null,[ 
                                        'class'=>'form-control',
                                        'id'=>'societe',
                                        'list'=>'list-societes'
                                    ]) }}
                                    <datalist id="list-societes">
                                    @foreach($societes as $societe)
                                        <option value="{{ $societe->nom_entreprise}}">{{ $societe->nom_entreprise }}</option>
                                    @endforeach
                                    </datalist>
                                </div>
                                <div class="form-group">
                                    {{ Form::label('fonction','Fonction :',[ 
                                        'class'=>'col-form-label',
                                    ]) }}
                                    {{ Form::text('fonction',null,[ 
                                        'class'=>'form-control',
                                        'id'=>'fonction',
                                        'list'=>'list-fonctions'
                                    ]) }}
                                    <datalist id="list-fonctions">
                                    @foreach($fonctions as $fonction)
                                        <option value="{{ $fonction->fonction}}">{{ $fonction->fonction }}</option>
                                    @endforeach
                                    </datalist>
                                </div>
                                <div class="form-group">
                                    {{ Form::label('in_cv','In CV :',[ 
                                        'class'=>'col-form-label',
                                    ]) }}
                                    {{ Form::text('in_cv',null,[ 
                                        'class'=>'form-control',
                                        'id'=>'in_cv',
                                    ]) }}
                                </div>
                                <div class="text-right">
                                    {{ Form::submit('Rechercher',['class'=>'btn btn-primary'])}}
                                </div>
                            </div>
                        </div>
                        {{ Form::close() }}

                        <form>
                            <fieldset><legend>Filtre</legend>
                            <div class="row">
                                <div style="width:200px">            
                                    <strong>Etat avancement</strong>
                                </div>
                                <div class="col-lg-9">
                                    <ul style="display:inline">
                                        <li style="display:inline"><a href="#">Tous</a><span>(61)</span></li>
                                        <li style="display:inline"><a href="#">A traiter</a><span>(14)</span></li>
                                        <li style="display:inline"><a href="#">A contacter</a><span>(9)</span></li>
                                        <li style="display:inline"><a href="#">A valider</a><span>(8)</span></li>
                                    </ul>
                                    <select>
                                        <option>Autres</option>
                                        <option>Autres</option>
                                        <option>Autres</option>
                                    </select>
                                </div>
                            <div class="row">
                                <div style="width:250px">            
                                    <strong>Mode candidature</strong>
                                </div>
                                <div class="col-lg-3">
                                    <ul style="display:inline">
                                        <li style="display:inline"><a href="#">Tous</a><span>(61)</span></li>
                                        <li style="display:inline"><a href="#">A traiter</a><span>(14)</span></li>
                                        <li style="display:inline"><a href="#">A contacter</a><span>(9)</span></li>
                                        <li style="display:inline"><a href="#">A valider</a><span>(8)</span></li>
                                    </ul>
                                    <select>
                                        <option>Autres</option>
                                        <option>Autres</option>
                                        <option>Autres</option>
                                    </select>
                            </div>
                        </form>
                        
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-candidats">
                                <thead>
                                    <tr>
                                        <th>Nom</th>
                                        <th>Prenom</th>
                                        <th>Date de naissance</th>
                                        <th>Date de création</th>
                                        <th>Supprimer</th>
                                        <th>Ajouter à une fiche</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @forelse($candidats as $candidat)
                                    <tr class="odd">
                                        <td>
                                            <a href="{{ route('candidats.show',$candidat->id)}}">
                                                {{ $candidat->nom}}
                                            </a>
                                        </td>
                                        <td>
                                            {{ $candidat->prenom}}
                                        </td>
                                        <td>
                                            {{ Carbon::parse($candidat->date_naissance)->format('d-m-Y') }}
                                        </td>
                                        <td>{{ Carbon::parse($candidat->created_at)->format('d-m-Y') }}</td>
                                        <td style="text-align: center">
                                            {{Form::open([
                                                'route'=>['candidats.destroy',$candidat->id],
                                                'method'=>'DELETE',
                                                'role'=>'form',
                                                'onsubmit' => 'return confirm("Etes vous sur de vouloir supprimer ce candidat")'
                                            ]) }}
                                                <button class="fa fa-trash" aria-hidden="true" title="supprimer candidat"></button>                                        
                                            {{ Form::close() }}
                                        </td>
                                        
                                        <td style="text-align: center">
                                            {{ Form::open([
                                                'route'=>['candidatures.store'],
                                                'method'=>'POST'
                                            ]) }}
                                            {{ Form::hidden('candidat_id',$candidat->id) }}
                                            {{ Form::select('mission_id',$ongoingMissions,'0') }}
                                            {{ Form::submit('OK') }}
                                            {{ Form::close() }}
                                        </td>
                                        
                                    </tr>
                                @empty
                                    <tr><td colspan="5">Aucun candidat.</td></tr>
                                @endforelse
                                </tbody>
                            </table>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
@endsection
