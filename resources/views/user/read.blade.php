@extends('layouts.app')

@section('entity-label', 'Usuário')
@section('entity-url', 'user')
@section('action-label', 'Visualizar')

@section('content')
<div class="row">
  <!-- col -->
  <div class="col-md-12">
    <!-- tile -->
    <section class="tile">
      <!-- tile header -->
      <div class="tile-header dvd dvd-btm">
        <h1 class="custom-font"><strong>Visualizar</strong> Usuário</h1>
      </div>
      <!-- /tile header -->
      <!-- tile body -->
      <div class="tile-body">
        <form class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-2 control-label">Nome</label>
            <div class="col-sm-10">
              <p class="form-control-static">{{ $user->name }}</p>
            </div>
          </div>
          <hr class="line-dashed line-full"/>
          <div class="form-group">
            <label class="col-sm-2 control-label">E-mail</label>
            <div class="col-sm-10">
              <p class="form-control-static">{{ $user->email }}</p>
            </div>
          </div>
          <hr class="line-dashed line-full"/>
          <div class="form-group">
            <label class="col-sm-2 control-label">Telefone</label>
            <div class="col-sm-10">
              <p class="form-control-static">({{ $user->phone_ddd }}) {{ $user->phone }}</p>
            </div>
          </div>
          <hr class="line-dashed line-full"/>
          <div class="form-group">
            <label class="col-sm-2 control-label">Telefone Celular</label>
            <div class="col-sm-10">
              <p class="form-control-static">({{ $user->mobile_ddd }}) {{ $user->mobile_phone }}</p>
            </div>
          </div>
          <hr class="line-dashed line-full"/>
          <div class="form-group">
            <label for="company" class="col-sm-2 control-label">Skype</label>
            <div class="col-sm-10">
              <p class="form-control-static">{{ $user->skype }}</p>
            </div>
          </div>
          @if(!empty($user->signature))
          <hr class="line-dashed line-full"/>
          <div class="form-group">
            <label for="company" class="col-sm-2 control-label">Assinatura</label>
            <div class="col-sm-10">
              <img src="data:image/jpeg;base64,{{ $user->signature }}" height="150" />
            </div>
          </div>
          @endif
        </form>
      </div>
      <!-- /tile body -->
    </section>
    <!-- /tile -->
  </div>
</div>
@endsection
