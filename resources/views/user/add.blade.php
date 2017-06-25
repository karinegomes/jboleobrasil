@extends('layouts.app')

@section('entity-label', 'Usuário')
@section('entity-url', 'user')
@section('action-label', 'Editar')

@section('content')
<div class="row">
  <!-- col -->
  <div class="col-md-12">
    <!-- tile -->
    <section class="tile">
      <!-- tile header -->
      <div class="tile-header dvd dvd-btm">
        <h1 class="custom-font"><strong>Novo</strong> Usuário</h1>
      </div>
      <!-- /tile header -->
      <!-- tile body -->
      <div class="tile-body">
        <form class="form-horizontal" enctype="multipart/form-data" method="post" action="{{ url('/user') }}">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <div class="form-group">
            <label for="name" class="col-sm-2 control-label">Nome</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
            </div>
          </div>
          <hr class="line-dashed line-full"/>
          <div class="form-group">
            <label for="email" class="col-sm-2 control-label">E-mail</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="email" name="email" value="{{ old('email') }}">
            </div>
          </div>
          <hr class="line-dashed line-full"/>
          <div class="form-group">
            <label for="skype" class="col-sm-2 control-label">Skype</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="skype" name="skype" value="{{ old('skype') }}">
            </div>
          </div>
          <hr class="line-dashed line-full"/>
          <div class="form-group">
            <label for="company" class="col-sm-2 control-label">Telefone</label>
            <div class="col-sm-1">
              <input class="form-control" name="phone_ddd" placeholder="DDD" value="{{ old('phone_ddd') }}">
            </div>
            <div class="col-sm-2">
              <input class="form-control" name="phone" placeholder="Número" value="{{ old('phone') }}">
            </div>
          </div>
          <hr class="line-dashed line-full"/>
          <div class="form-group">
            <label for="company" class="col-sm-2 control-label">Telefone Celular</label>
            <div class="col-sm-1">
              <input class="form-control" name="mobile_ddd" placeholder="DDD" value="{{ old('mobile_ddd') }}">
            </div>
            <div class="col-sm-2">
              <input class="form-control" name="mobile_phone" placeholder="Número" value="{{ old('mobile_phone') }}">
            </div>
          </div>
          <hr class="line-dashed line-full"/>
          <div class="form-group">
            <label for="signature" class="col-sm-2 control-label">Assinatura</label>
            <div class="col-sm-5">
              <input type="file" class="form-control" id="signature" name="signature">
            </div>
          </div>
          <hr class="line-dashed line-full"/>
          <div class="form-group">
            <label for="password" class="col-sm-2 control-label">Senha</label>
            <div class="col-sm-5">
              <input type="password" class="form-control" id="password" name="password">
            </div>
          </div>
          <hr class="line-dashed line-full"/>
          <div class="form-group">
            <label for="admin" class="col-sm-2 control-label">Administrador</label>
            <div class="col-sm-5">
              <input type="checkbox" id="admin" name="is_admin" value="1"{{ old('is_admin') == 1 ? ' checked' : '' }}>
            </div>
          </div>
          <hr class="line-dashed line-full"/>
          <div class="form-group">
            <div class="col-sm-4 col-sm-offset-2">
              <button type="reset" class="btn btn-lightred">Limpar</button>
              <button type="submit" class="btn btn-default">Salvar</button>
            </div>
          </div>
        </form>
      </div>
      <!-- /tile body -->
    </section>
    <!-- /tile -->
  </div>
  <!-- /col -->
</div>
@endsection
