@extends('layouts.app')

@include('includes.sidebar')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default" id="frmRegister">
                <div class="panel-heading">User Profile</div>

                <div class="panel-body">
                    {{ Form::open([
                            'route'=>$route,
                            'method'=>$method,
                            'role'=>'form',
                            'class'=>'form-horizontal',
                    ]) }}
                @if(auth()->user()->is_admin)          
                    <div class="form-group{{ $errors->has('role') ? ' has-error' : '' }}">
                        <label for="role" class="col-md-4 control-label">Rôle :</label>

                        <div class="col-md-6">
                        {{ Form::select('role', 
                            $roles,
                            old('role') ? old('role') : (isset($user) ? $user->roles()->get()->first()->id: null),
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
                        <label for="lastname" class="col-md-4 control-label">Lastname :</label>

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
                            <label for="firstname" class="col-md-4 control-label">Firstname :</label>

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
                            <label for="initials" class="col-md-4 control-label">Initials :</label>

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
                            <label for="language" class="col-md-4 control-label">Language :</label>

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
                            <label for="login" class="col-md-4 control-label">Login :</label>

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
                            <label for="email" class="col-md-4 control-label">E-Mail :</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') ?? (isset($user) ? $user->email : '') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                                  
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password :</label>

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
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password :</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" {{ empty($user) ? 'required':''}}>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4 bottom-bar">
                                {{ Form::submit('Register',[
                                'class'=>'btn btn-primary pull-right',
                                ]) }}
                                <button class="btn btn-secondary pull-right" type="button"><a href="{{url()->previous()}}">Cancel</a></button>
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
