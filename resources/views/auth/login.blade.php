@extends('layouts.login')

@section('content')
<div class="container w-420 p-15 bg-white mt-40 text-center">
  <img src="{{asset('img/logo.png')}}" alt="Logo JB Oleo Brasil" width="100%"/>
  <form class="form-validation mt-20" role="form" method="POST" action="{{ url('/login') }}">
    {{ csrf_field() }}
    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
      <input id="email" type="email" class="form-control underline-input" placeholder="Email" name="email" value="{{ old('email') }}">
      @if ($errors->has('email'))
      <span class="help-block">
        <strong>{{ $errors->first('email') }}</strong>
      </span>
      @endif
    </div>
    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
      <input id="password" type="password" placeholder="Password" class="form-control underline-input" name="password">
      @if ($errors->has('password'))
      <span class="help-block">
        <strong>{{ $errors->first('password') }}</strong>
      </span>
      @endif
    </div>
    <div class="form-group text-left mt-20">
      <button type="submit" class="btn btn-greensea b-0 br-2 mr-5">Login</button>
      <label class="checkbox checkbox-custom-alt checkbox-custom-sm inline-block">
        <input type="checkbox" name="remember"><i></i> Remember me
      </label>
    </div>
  </form>
</div>
@endsection
