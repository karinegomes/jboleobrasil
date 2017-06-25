@extends('layouts.app')

@section('entity-label', 'Contrato')
@section('entity-url', 'order')
@section('action-label', 'Visualizar')

@section('content')
<div class="row">
  <!-- col -->
  <div class="col-md-6">
    <!-- tile -->
    <section class="tile">
      <!-- tile header -->
      <div class="tile-header dvd dvd-btm">
        <h1 class="custom-font"><strong>Visualizar</strong> Contato</h1>
        <ul class="controls">
          <li>
            <a role="button" tabindex="0" href="{{ url('/order/'.$order->id.'/edit') }}">
              <span class="fa fa-pencil mr-5"></span>Editar
            </a>
          </li>
        </ul>
      </div>
      <!-- /tile header -->
      <!-- tile body -->
      <div class="tile-body">
        <form class="form-horizontal">
          <div class="form-group">
            <label for="name" class="col-sm-2 control-label">Nome</label>
            <div class="col-sm-10">
              <p class="form-control-static">{{ $order->name }}</p>
            </div>
          </div>
          <hr class="line-dashed line-full"/>
          <div class="form-group">
            <label for="position" class="col-sm-2 control-label">Cargo</label>
            <div class="col-sm-10">
              <p class="form-control-static">{{ $order->position }}</p>
            </div>
          </div>
          <hr class="line-dashed line-full"/>
          <div class="form-group">
            <label for="email" class="col-sm-2 control-label">E-mail</label>
            <div class="col-sm-10">
              <p class="form-control-static">{{ $order->email }}</p>
            </div>
          </div>
          <hr class="line-dashed line-full"/>
          <div class="form-group">
            <label for="company" class="col-sm-2 control-label">Empresa</label>
            <div class="col-sm-10">
              <p class="form-control-static">{{ $order->company->name }}</p>
            </div>
          </div>
          <hr class="line-dashed line-full"/>
          <div class="form-group">
            <label for="company" class="col-sm-2 control-label">Telefones</label>
            <div class="col-sm-10">
              @foreach($order->telephones as $telephone)
              <div class="row telephones" style="margin-top: 5px">
                <div class="col-sm-1">
                  <p class="form-control-static">{{ $telephone->ddd }}</p>
                </div>
                <div class="col-sm-3">
                  <p class="form-control-static">{{ $telephone->number }}</p>
                </div>
                <div class="col-sm-8">
                  {!! ($telephone->main)?'<strong>Telefone Principal</strong>':'' !!}
                </div>
              </div>
              @endforeach
            </div>
          </div>
          <hr class="line-dashed line-full"/>
          <div class="form-group">
            <label for="identity" class="col-sm-2 control-label">CPF</label>
            <div class="col-sm-10">
              <p class="form-control-static">{{ $order->identity }}</p>
            </div>
          </div>
          <hr class="line-dashed line-full"/>
          <div class="form-group">
            <label for="city" class="col-sm-2 control-label">Cidade</label>
            <div class="col-sm-10">
              <p class="form-control-static">{{ $order->state_name }}</p>
            </div>
          </div>
        </form>
      </div>
      <!-- /tile body -->
    </section>
    <!-- /tile -->
  </div>
  <div class="col-md-6">
    <!-- tile -->
    <section class="tile">
      <!-- tile header -->
      <div class="tile-header dvd dvd-btm">
        <h1 class="custom-font"><strong>Visualizar</strong> Anotações</h1>
      </div>
      <!-- /tile header -->
      <!-- tile body -->
      <div class="tile-body">
      </div>
    </section>
  </div>
  <!-- /col -->
</div>
@endsection
