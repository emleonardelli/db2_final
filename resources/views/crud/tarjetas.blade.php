@extends('layouts.app')
@section('title')CRUD - Tarjetas de Creditos @endsection

@section('content')
<section class="hero is-danger welcome is-small">
  <div class="hero-body">
      <div class="container">
          <h1 class="title">
						Tarjetas de Creditos!
          </h1>
          <h2 class="subtitle">
              Alta, Baja y Modificacion de Tarjetas de Creditos
          </h2>
      </div>
  </div>
</section>

<div class="column is-full has-text-left">
	<form action="/clientes/tarjetas" method="post">
		{{ csrf_field() }}
		<input type="hidden" name="cliente_id" value="{{ $cliente_id }}">
		@if (isset($get))
			<input type="hidden" name="id" value="{{ $get->getId() }}">
		@endif
		<label class="label">Crear tarjeta</label>	
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
							<i class="fas fa-id-card"></i>
						</span>
					</p>
				</div>
				<div class="field">
					<p class="control is-expanded has-icons-left">
						<input class="input" 
							name="numero" 
							type="number"
							placeholder="Numero"
							required
							value="{{ isset($get) ? $get->getNumero() : '' }}">
						<span class="icon is-small is-left">
							<i class="fas fa-user"></i>
						</span>
					</p>
				</div>
				<div class="field">
					<p class="control is-expanded has-icons-left">
						<input class="input" 
							name="disponible" 
							type="number" 
							placeholder="Disponible"
							required
							value="{{ isset($get) ? $get->getDisponible() : '' }}">
						<span class="icon is-small is-left">
							<i class="fas fa-dollar-sign"></i>
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

<div class="column is-full has-text-left">
	<table class="table is-fullwidth">
		<thead>
			<tr>
				<th>#</th>
				<th>Nombre</th>
				<th>Numero</th>
				<th>Disponible</th>
				<th>Acciones</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($list as $var)
				<tr>
					<td>{{ $var->getId() }}</td>
					<td>{{ $var->getNombre() }}</td>
					<td>{{ $var->getNumero() }}</td>
					<td>$ {{ number_format($var->getDisponible(), 2, ',', '.') }}</td>
					<td >
						<a class="button is-warning is-pulled-left	"
							href="/clientes/tarjetas?cliente_id={{ $cliente_id }}&tarjeta_id={{ $var->getId() }}">
							<i class="fas fa-id-card"></i>
						</a>
						<form action="/clientes/tarjetas" method="post" class="is-pulled-left	">
							{{ csrf_field() }}
							<input type="hidden" name="_method" value="delete" />
							<input type="hidden" name="id" value="{{ $var->getId() }}">
							<button class="button is-danger"><i class="fas fa-id-card"></i></button>
						</form>
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</div>
@endsection