@extends('layouts.app')

@section('title',__('general.add_record',['record'=>trans_choice('general.user',1)]))

@section('js')
<script>
$(function() {
    $('#password,#password-confirm').on('change', function() {
        var password = $('#password').val();
        var passwordConfirm = $('#password-confirm').val();
        var $oldPassword = $('#old_password');
        
        if(password!='' || passwordConfirm!='') {
            $oldPassword.attr('required','required');
        } else if(password=='' && passwordConfirm=='') {
            $oldPassword.removeAttr('required');
        }
    });
    
});
</script>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default" id="frmRegister">
                <div class="panel-heading">{{__('general.user_profile')}}</div>

                <div class="panel-body">
                    {{ Form::open([
                            'route'=>$route,
                            'method'=>$method,
                            'role'=>'form',
                            'class'=>'form-horizontal',
                    ]) }}
                @if(auth()->user()->is_admin)          
                    <div class="form-group{{ $errors->has('role') ? ' has-error' : '' }}">
                        <label for="role" class="col-md-4 control-label">{{ ucfirst(__('validation.attributes.role')) }}&nbsp;:</label>

                        <div class="col-md-6">
                        {{ Form::select('role', 
                            $roles,
                            old('role') ? old('role') : (isset($user) ? $user->roles()->get()->first()->id: $roleEmployeeId),
                        [
                            'class'=>'form-control',
                            'id'=>'role',
                            'required'=>true,
                        ])}}
                            @if ($errors->has('role'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('role') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                @endif            
                    <div class="form-group{{ $errors->has('lastname') ? ' has-error' : '' }}">
                        <label for="lastname" class="col-md-4 control-label">{{ ucfirst(__('validation.attributes.last_name')) }}&nbsp;:</label>

                            <div class="col-md-6">
                            @if(isset($user))
                                <p>{{ $user->lastname }}<p>
                            @else
                                <input id="lastname" type="text" class="form-control" name="lastname" value="{{ old('lastname') }}" required>

                                @if ($errors->has('lastname'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('lastname') }}</strong>
                                    </span>
                                @endif
                            @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('firstname') ? ' has-error' : '' }}">
                            <label for="firstname" class="col-md-4 control-label">{{ ucfirst(__('validation.attributes.first_name')) }}&nbsp;:</label>

                            <div class="col-md-6">
                            @if(isset($user))
                                <p>{{ $user->firstname }}<p>
                            @else
                                <input id="firstname" type="text" class="form-control" name="firstname" value="{{ old('firstname') }}" required>

                                @if ($errors->has('firstname'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('firstname') }}</strong>
                                    </span>
                                @endif
                            @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('initials') ? ' has-error' : '' }}">
                            <label for="initials" class="col-md-4 control-label">{{ ucfirst(__('validation.attributes.initials')) }}&nbsp;:</label>

                            <div class="col-md-6">
                            @if(isset($user))
                                <p>{{ $user->initials }}<p>
                            @else
                                <input id="initials" type="text" maxlength="2" class="form-control" name="initials" value="{{ old('initials') }}" required>

                                @if ($errors->has('initials'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('initials') }}</strong>
                                    </span>
                                @endif
                            @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('language') ? ' has-error' : '' }}">
                            <label for="language" class="col-md-4 control-label">{{ ucfirst(__('validation.attributes.language')) }}&nbsp;:</label>

                            <div class="col-md-6">
                            {{ Form::select('language', 
                                $languages,
                                old('language') ? old('language') : (isset($user) ? $user->language: null),
                            [
                                'class'=>'form-control',
                                'id'=>'language',
                                'required'=>true,
                            ])}}
                                @if ($errors->has('language'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('language') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('login') ? ' has-error' : '' }}">
                            <label for="login" class="col-md-4 control-label">{{ ucfirst(__('validation.attributes.login')) }}&nbsp;:</label>

                            <div class="col-md-6">
                            @if(isset($user))
                                <p>{{ $user->login }}<p>
                            @else
                                <input id="login" type="text" class="form-control" name="login" value="{{ old('login') }}" required>

                                @if ($errors->has('login'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('login') }}</strong>
                                    </span>
                                @endif
                            @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">{{ ucfirst(__('validation.attributes.email')) }}&nbsp;:</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') ?? (isset($user) ? $user->email : '') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    @if(isset($user))
                        <div class="form-group{{ $errors->has('old_password') ? ' has-error' : '' }}">
                            <label for="old_password" class="col-md-4 control-label">{{ ucfirst(__('validation.attributes.old_password')) }} :</label>

                            <div class="col-md-6">
                                <input id="old_password" type="password" class="form-control" name="old_password" {{ empty($user) ? 'required':''}}>
                                @if($errors->has('old_password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('old_password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endif
                                  
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">{{ ucfirst(__('validation.attributes.password')) }} :</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" {{ empty($user) ? 'required':''}}>
                                @if(empty($user) && $errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">{{ ucfirst(str_replace(' ',"&nbsp;",__('validation.attributes.password_confirmation'))) }}&nbsp;:</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" {{ empty($user) ? 'required':''}}>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4 bottom-bar">
                                {{ Form::submit(__('general.save'),[
                                'class'=>'btn btn-primary pull-right',
                                ]) }}
                                <button class="btn btn-secondary pull-right" type="button"><a href="{{url()->previous()}}">{{__('general.cancel')}}</a></button>
                            </div>
                        </div>
                    </form>
                {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
