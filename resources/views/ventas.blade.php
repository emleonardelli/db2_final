@extends('layouts.app')
@section('title')Ventas @endsection
@section('content')
<section class="hero is-info welcome is-small">
    <div class="hero-body">
        <div class="container">
            <h1 class="title">
                Ventas realizadas
            </h1>
            <h2 class="subtitle">
                Todas las ventas del sistema
            </h2>
        </div>
    </div>
</section>
<div class="column is-full has-text-left">
	<table class="table is-fullwidth">
		<thead>
			<tr>
				<th>#</th>
                <th>Fecha</th>
                <th>Detalle</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($list as $var)
				<tr>
                    <td>{{ $var->getId() }}</td>
                    <td>{{ $var->getFecha() }}</td>
					<td>{!! $var->getDescripcion() !!}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</div>
@endsection