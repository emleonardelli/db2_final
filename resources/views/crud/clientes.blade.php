@extends('layouts.app')
@section('title')CRUD - Clientes @endsection

@section('content')
<section class="hero is-primary welcome is-small">
  <div class="hero-body">
      <div class="container">
          <h1 class="title">
              Clientes!
          </h1>
          <h2 class="subtitle">
              Alta, Baja y Modificacion de Clientes
          </h2>
      </div>
  </div>
</section>

<div class="column is-full has-text-left">
	<form action="/clientes" method="post">
		{{ csrf_field() }}
		@if (isset($get))
			<input type="hidden" name="id" value="{{ $get->getId() }}">
		@endif
		<label class="label">Crear cliente</label>	
		<div class="field is-horizontal">
			<div class="field-body">
				<div class="field">
					<p class="control is-expanded has-icons-left">
						<input class="input" 
							name="nombre" 
							type="text"
							placeholder="Nombre"
							required
							value="{{ isset($get) ? $get->getNombre() : '' }}">
						<span class="icon is-small is-left">
							<i class="fas fa-user"></i>
						</span>
					</p>
				</div>
				<div class="field">
					<p class="control is-expanded has-icons-left">
						<input class="input" 
							name="apellido" 
							type="text"
							placeholder="Apellido"
							required
							value="{{ isset($get) ? $get->getApellido() : '' }}">
						<span class="icon is-small is-left">
							<i class="fas fa-user"></i>
						</span>
					</p>
				</div>
			</div>
		</div>
		<div class="field is-horizontal">
			<div class="field-body">
				<div class="field">
					<p class="control is-expanded has-icons-left">
						<input class="input" 
							name="dni" 
							type="number" 
							placeholder="Dni"
							required
							value="{{ isset($get) ? $get->getDni() : '' }}">
						<span class="icon is-small is-left">
							<i class="fas fa-file"></i>
						</span>
					</p>
				</div>
				<div class="field">
					<p class="control is-expanded has-icons-left">
						<input class="input" 
							name="email" 
							type="text" 
							placeholder="Email"
							required
							value="{{ isset($get) ? $get->getEmail() : '' }}">
						<span class="icon is-small is-left">
							<i class="fas fa-envelope"></i>
						</span>
					</p>
				</div>
				<div class="field">
					<p class="control is-expanded has-icons-left">
						<button class="button is-link"">Guardar</button>
					</p>
				</div>
			</div>
		</div>
	</form>
</div>
@if($errors->any())
<div class="notification is-danger">
  <button class="delete"></button>
  @foreach ($errors->all() as $message) 
    {{ $message }}
	@endforeach
</div>
@endif
<div class="column is-full has-text-left">
	<table class="table is-fullwidth">
		<thead>
			<tr>
				<th>#</th>
				<th>Nombre</th>
				<th>DNI</th>
				<th>Email</th>
				<th>Acciones</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($list as $var)
				<tr>
					<td>{{ $var->getId() }}</td>
					<td>{{ $var->getNombre() }} {{ $var->getApellido() }}</td>
					<td>{{ $var->getDni() }}</td>
					<td>{{ $var->getEmail() }}</td>
					<td >
						<a class="button is-success is-pulled-left	"
							href="/clientes/tarjetas?cliente_id={{ $var->getId() }}">
							<i class="fas fa-id-card"></i>
						</a>
						<a class="button is-warning is-pulled-left	"
							href="/clientes?id={{ $var->getId() }}">
							<i class="fas fa-user-edit"></i>
						</a>
						<form action="/clientes" method="post" class="is-pulled-left	">
							{{ csrf_field() }}
							<input type="hidden" name="_method" value="delete" />
							<input type="hidden" name="id" value="{{ $var->getId() }}">
							<button class="button is-danger"><i class="fas fa-user-minus"></i></button>
						</form>
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</div>
@endsection