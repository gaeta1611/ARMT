@extends('layouts.app')

@section('title',__('general.titles.search_candidate'))

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

        //Ajoutdu du bouton de reset des datalists
        $('input[list]').after('<span class="reset-datalist"><i class="fa fa-times"></i></span>');
        $('div.form-group').on('mouseover',function(){
            $(this).find('span.reset-datalist').css('display','inline');
        }).on('mouseout',function(){
            $(this).find('span.reset-datalist').css('display','none');
        });
        $('span.reset-datalist').on('click',function() {
            $input = $(this).parent().find('input[list]').val('');
            $input.val('');
        });

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
        
        $('#status').on('change',function() {
            var status = $(this).val();

            var redirectURL = APP_URL+'/public/candidats?status='+encodeURIComponent(status);

            location.href = redirectURL;
        });

        $('#mode').on('change',function() {
            var typeMode = $(this).val().split('|',2);

            if(typeMode.length==2) {
                var type = typeMode[0];
                var mode = typeMode[1];

                var redirectURL = APP_URL+'/public/candidats?type='+encodeURIComponent(type)+'&mode='+encodeURIComponent(mode);

                location.href = redirectURL;
            }          
        });
        $('#frmSearchCandidat').on('reset',function(event){
            var indexURL = APP_URL+'/public/candidats';
            if(location.href!= indexURL){
                location.href = indexURL;

                event.preventDefault();
                return false;
            }
        });
    });
</script>
@endsection

@section('content')
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">{{ __('general.titles.search_candidate')}}</h1>
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
                                    {{ Form::label('age',__('general.age').' : ',[ 
                                        'class'=>'col-form-label',
                                    ]) }}
                                    <div class="input-group">
                                    <span class="input-group-addon" id="age-addon-min">Entre</span>
                                        {{ Form::number('age-min',null,[ 
                                            'class'=>'form-control',
                                            'id'=>'age-min',
                                            'aria-describedby'=>'age-addon-min'
                                        ]) }}
                                        <span class="input-group-addon" id="age-addon-max">Et</span>
                                        {{ Form::number('age-max',null,[ 
                                            'class'=>'form-control',
                                            'id'=>'age-max',
                                            'aria-describedby'=>'age-addon-max'
                                        ]) }}

                                    </div>
                                </div>
                                <div class="form-group">
                                {{ Form::label('langues',ucfirst(__('validation.attributes.language')).' : ')}}
                                <p>0=>{{ trans_choice('general.language_level',1) }} | 1=>{{ trans_choice('general.language_level',2) }} | 2=>{{ trans_choice('general.language_level',3) }} | 
                                            3=>{{ trans_choice('general.language_level',4) }} | 4=>{{ trans_choice('general.language_level',5) }} | 5=>{{ trans_choice('general.language_level',6) }}<p>
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
                                    {{ Form::label('designation',__('general.degree').' : ',[ 
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
                                    {{ Form::label('finalite',__('general.finality').' : ',[ 
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
                                    {{ Form::label('niveau',__('general.level').' : ',[ 
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
                                    {{ Form::label('code_ecole',__('general.school').' : ',[ 
                                        'class'=>'col-form-label',
                                    ]) }}
                                    {{ Form::text('code_ecole',null,[ 
                                        'class'=>'form-control',
                                        'id'=>'code_ecole',
                                        'list'=>'list-ecoles'
                                    ]) }}
                                    <datalist id="list-ecoles">
                                    @foreach($ecoles as $ecole)
                                        <option value="{{ $ecole->code_ecole}}">{{ $ecole->code_ecole }}</option>
                                    @endforeach
                                    </datalist>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    {{ Form::label('societe',__('general.employer').' : ',[ 
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
                                    {{ Form::label('fonction',ucfirst(trans_choice('general.function',1)).' : ',[ 
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
                                    {{ Form::label('in_cv',__('general.cv').' : ',[ 
                                        'class'=>'col-form-label',
                                    ]) }}
                                    {{ Form::text('in_cv',null,[ 
                                        'class'=>'form-control',
                                        'id'=>'in_cv',
                                    ]) }}
                                </div>
                                <div class="text-right">
                                    {{ Form::reset(__('general.clear_all'),['class'=>'btn btn-secondary'])}}
                                    {{ Form::submit(__('general.search'),['class'=>'btn btn-primary'])}}
                                </div>
                            </div>
                        </div>
                        {{ Form::close() }}

                        <form>
                            <fieldset><legend>{{__('general.filter')}}</legend>
                            <div class="row">
                                <div style="width:150px; float: left;margin:0 15px">
                                    <strong>{{__('general.advancement')}} :</strong>
                                </div>
                                <div style=" float: left">
                                    <ul style="display: inline; padding: 0">
                                        <li style="display: inline">{{ HTML::linkRoute('candidats.index',__('general.all')) }} <span>({{ $counters['all'] }})</span></li>
                                        <li style="display: inline">{{ HTML::linkRoute('candidats.index',__('general.treat'),['status'=>'à traiter']) }} <span>({{ $counters['à traiter'] }})</span></li>
                                        <li style="display: inline">{{ HTML::linkRoute('candidats.index',__('general.to_contact'),['status'=>'à contacter']) }} <span>({{ $counters['à contacter'] }})</span></li>
                                        <li style="display: inline">{{ HTML::linkRoute('candidats.index',__('general.to_validate'),['status'=>'à valider']) }} <span>({{ $counters['à valider'] }})</span></li>
                                        
                                    </ul>
                                    <select name="status" id="status">
                                        <option></option>
                                    @foreach($avancements as $avancement)
                                        <option @if($avancement->avancement==app('request')->input('status')) selected @endif>{{ $avancement->avancement }}</option>
                                    @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div style="width:150px; float: left;margin:0 15px">
                                    <strong>{{__('general.candidacy_mode')}} : </strong>
                                </div>
                                <div style=" float: left">
                                    <ul style="display: inline; padding: 0">
                                        <li style="display: inline">{{ HTML::linkRoute('candidats.index','Stepstone',['mode'=> 'Stepstone']) }} <span>({{ $counters['Stepstone'] }})</span></li>
                                        <li style="display: inline">{{ HTML::linkRoute('candidats.index','DB Stepstone',['type'=>'DB','mode'=>'Stepstone']) }} <span>({{ $counters['DB Stepstone'] }})</span></li>
                                        <li style="display: inline">{{ HTML::linkRoute('candidats.index','DB adva',['type'=>'DB','mode'=>'adva']) }} <span>({{ $counters['DB adva'] }})</span></li>
                                    </ul>
                                    <select name="mode" id="mode">
                                        <option></option>
                                    @foreach($modeCandidatures as $modeCandidature)
                                        <option value="{{ $modeCandidature->media->type.'|'.$modeCandidature->media->mode }}" @if($modeCandidature->media->type==app('request')->input('type') && $modeCandidature->media->mode==app('request')->input('mode') ) selected @endif>
                                            {{ $modeCandidature->media->type.' '.$modeCandidature->media->mode }}
                                        </option>
                                    @endforeach
                                    </select>
                                </div>
                            </div>
                            </fieldset>
                         </form>
                        
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                        @if($candidats->count())
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-candidats">
                                <thead>
                                    <tr>
                                        <th>{{ ucfirst(__('validation.attributes.last_name')) }}</th>
                                        <th>{{ ucfirst(__('validation.attributes.first_name')) }}</th>
                                        <th>{{__('general.birth_date')}}</th>
                                        <th>{{__('general.created_at')}}</th>
                                        <th>{{__('general.delete')}}</th>
                                        <th>{{__('general.titles.add_a_mission')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($candidats as $candidat)
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
                                            {{ isset($candidat->date_naissance) ? Carbon::parse($candidat->date_naissance)->format('d-m-Y'):'' }}
                                        </td>
                                        <td>{{ Carbon::parse($candidat->created_at)->format('d-m-Y') }}</td>
                                        <td style="text-align: center">
                                            {{Form::open([
                                                'route'=>['candidats.destroy',$candidat->id],
                                                'method'=>'DELETE',
                                                'role'=>'form',
                                                'onsubmit' => 'return confirm("'.__('general.delete_confirmation',[
                                                    'pronoun'=>trans_choice('general.pronouns.this',1), 
                                                    'record'=>__('general.candidate'),
                                                ]).'")'
                                            ]) }}
                                                <button class="fa fa-trash" aria-hidden="true" title="{{ __('general.delete_record',['record'=>__('general.candidate')]) }}"></button>                                        
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
                                
                                @endforeach
                                </tbody>
                            </table>
                            <!-- /.table-responsive -->
                        @else   
                            <p><strong>Aucun Candidat.</strong></p>
                        @endif
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
@endsection
