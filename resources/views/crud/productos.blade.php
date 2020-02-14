@extends('layouts.app')
@section('title')CRUD - Productos @endsection

@section('content')
<section class="hero is-success welcome is-small">
  <div class="hero-body">
      <div class="container">
          <h1 class="title">
              Productos!
          </h1>
          <h2 class="subtitle">
              Alta, Baja y Modificacion de Productos
          </h2>
      </div>
  </div>
</section>

<div class="column is-full has-text-left">
	<form action="/productos" method="post">
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
							name="descripcion" 
							type="text"
							placeholder="Descripcion"
							required
							value="{{ isset($get) ? $get->getDescripcion() : '' }}">
						<span class="icon is-small is-left">
							<i class="fas fa-user"></i>
						</span>
					</p>
				</div>
				<div class="field">
					<p class="control is-expanded has-icons-left">
						<input class="input" 
							name="categoria" 
							type="text"
							placeholder="Categoria"
							required
							value="{{ isset($get) ? $get->getCategoria() : '' }}">
						<span class="icon is-small is-left">
							<i class="fas fa-user"></i>
						</span>
					</p>
				</div>
				<div class="field">
					<p class="control is-expanded has-icons-left">
						<input class="input" 
							name="precio" 
							type="number" 
							placeholder="Precio"
							required
							value="{{ isset($get) ? $get->getPrecio() : '' }}">
						<span class="icon is-small is-left">
							<i class="fas fa-file"></i>
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
				<th>Descripcion</th>
				<th>Categoria</th>
				<th>Precio</th>
				<th>Acciones</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($list as $var)
				<tr>
					<td>{{ $var->getId() }}</td>
					<td>{{ $var->getDescripcion() }}</td>
					<td>{{ $var->getCategoria() }}</td>
					<td>{{ $var->getPrecio() }}</td>
					<td >
						<a class="button is-warning is-pulled-left	"
							href="/productos?id={{ $var->getId() }}">
							<i class="fas fa-user-edit"></i>
						</a>
						<form action="/productos" method="post" class="is-pulled-left	">
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