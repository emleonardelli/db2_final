@extends('layouts.app')
@section('title')Carritos @endsection

@section('content')
<section class="hero is-info welcome is-small">
    <div class="hero-body">
        <div class="container">
            <h1 class="title">
                Carrito de compras!
            </h1>
            <h2 class="subtitle">
                Armar carrito de compras
            </h2>
            <p id="carrito-informacion"></p>
        </div>
    </div>
</section>

<div class="column is-full has-text-left">
	<table class="table is-fullwidth">
		<thead>
			<tr>
				<th>#</th>
				<th>Cliente</th>
				<th>Productos</th>
				<th>Precio</th>
				<th>Acciones</th>
			</tr>
		</thead>
		<tbody>
            @foreach ($list as $var)
                @if (!$var->getPagado())
                    
				<tr>
                    <td>{{ $var->getId() }}</td>
					<td>{{ $var->getCliente()->getNombre() }}</td>
					<td>{{ count($var->getProductos()) }}</td>
					<td>
                        @php 
                            $precio=0; 
                            foreach ($var->getProductos() as $var2) {
                                $precio+=$var2->getPrecio()*1;
                            }    
                            @endphp
                        $ {{ number_format($precio, 2, ',', '.') }}
                    </td>
                    <td >
                        <a href="/venta/pagar/{{ $var->getId() }}"
                            class="button is-success">
                            <i class="fas fa-cart-plus"></i>
                        </a>
                        <a href="/carrito/borrar?id={{ $var->getId() }}"
                            class="button is-danger">
                            <i class="fas fa-cart-arrow-down"></i>
                        </a>
                    </td>
                </tr>
                @endif
			@endforeach
		</tbody>
	</table>
</div>

<br>
<div class="columns">
    <div class="column is-6">
        <div class="card">
            <header class="card-header">
                <p class="card-header-title">
                    Clientes&nbsp;<small>(seleccione uno)</small>
                </p>
            </header>
            <div class="card-table">
                <div class="content">
                    <table class="table is-fullwidth is-striped">
                        <tbody>
                            @foreach ($cliente_list as $var)
                            <tr>
                                <td width="5%"><i class="fa fa-user"></i></td>
                                <td>{{ $var->getNombre() }} {{ $var->getApellido() }}</td>
                                <td class="level-right">
                                    <button class="button is-small is-primary"
                                        id="cliente_{{ $var->getId() }}"
                                        nombreCliente="{{ $var->getNombre() }} {{ $var->getApellido() }}"
                                        onclick="seleccionarCliente({{ $var->getId() }})">
                                        Seleccionar
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="column is-6">
        <div class="card">
            <header class="card-header">
                <p class="card-header-title">
                    Productos&nbsp;<small>(seleccione uno o varios)</small>
                </p>
            </header>
            <div class="card-table">
                <div class="content">
                    <table class="table is-fullwidth is-striped">
                        <tbody>
                            @foreach ($producto_list as $var)
                            <tr>
                                <td width="5%"><i class="fa fa-user"></i></td>
                                <td>
                                    {{ $var->getDescripcion() }} $ {{ number_format($var->getPrecio(), 2, ',', '.') }} &nbsp;
                                    <small>({{ $var->getCategoria()->getNombre() }})</small>
                                </td>
                                <td class="level-right">
                                    <button class="button is-small is-primary"
                                            precio="{{ $var->getPrecio() }}"
                                            id="producto_{{ $var->getId() }}"
                                            onclick="seleccionarProducto({{ $var->getId() }})">
                                        Seleccionar
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
<script>
    let cliente=null
    let productos=[]
    let precio=0

    function seleccionarCliente(clienteId){
        let boton=document.getElementById(`cliente_${clienteId}`)
        
        if (cliente==clienteId){
            cliente=null
            marcar(boton)
            return
        }
        if (!cliente) {
            cliente=clienteId
        }else{
            alert('Solo puede seleccionar un cliente')
            return 
        }        
        marcar(boton)
    }

    function seleccionarProducto(productoId){
        let boton=document.getElementById(`producto_${productoId}`)
        const precioActual=boton.attributes.precio.value*1
        let existe=false
        for( var i = 0; i < productos.length; i++){ 
            if ( productos[i] === productoId) {
                productos.splice(i, 1); 
                precio-=precioActual
                existe=true
            }
        }
        if (!existe) {
            precio+=precioActual
            productos.push(productoId) 
        }
        marcar(boton)
    }

    function marcar(boton){
        if (boton.innerHTML.trim() == "Seleccionar"){
            boton.innerHTML='Seleccionado'
        }else{
            boton.innerHTML='Seleccionar'
        }
        boton.classList.toggle('is-primary')
        boton.classList.toggle('is-info')
        boton.parentElement.parentElement.classList.toggle('has-background-light')
        actualizarCarrito()
    }

    function actualizarCarrito(){
        let info=document.getElementById('carrito-informacion')
        info.innerHTML=null
        let precioFormateado = numeral(precio).format('$0,0.00');

        if (cliente != null && precio != 0 ){
            const nombreCliente=document.getElementById(`cliente_${cliente}`).attributes.nombreCliente.value
            info.innerHTML=`Cliente: ${nombreCliente} - Total Carrito ${precioFormateado}`+
                            `<br><a href="/carrito/guardar?cliente_id=${cliente}&productos=${productos}" class="button is-success">Guardar</a>`
        }
    }

</script>
@endsection