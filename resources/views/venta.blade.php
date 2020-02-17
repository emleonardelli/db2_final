@extends('layouts.app')
@section('title')Realizar venta @endsection

@section('content')
<section class="hero is-danger welcome is-small">
    <div class="hero-body">
        <div class="container">
            <h1 class="title">
                Proceso de venta!
            </h1>
            <h2 class="subtitle">
                Completar la venta
            </h2>
            <p id="venta-informacion"></p>
        </div>
    </div>
</section>
<br>
@if($errors->any())
<div class="notification is-warning">
  La tarjeta seleccionada supero el limite disponible!
</div>
@endif
<div class="columns is-multiline">
    <div class="column is-6">
        <div class="card">
            <header class="card-header">
                <p class="card-header-title">
                    Cliente
                </p>
            </header>
            <div class="card-table">
                <div class="content">
                    <table class="table is-fullwidth is-striped">
                        <tbody>
                            <tr>
                                <td width="5%"><i class="fa fa-user"></i></td>
                                <td>{{ $cliente->getNombre() }} {{ $cliente->getApellido() }} </td>
                                <td class="level-right">
                                    {{ $cliente->getEmail() }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card ">
            <header class="card-header">
                <p class="card-header-title">
                    Productos del carrito
                </p>
            </header>
            <div class="card-table">
                <div class="content">
                    <table class="table is-fullwidth is-striped">
                        <tbody>
                            @php
                                $total=0;
                            @endphp
                            @foreach ($carrito->getProductos() as $var)
                            <tr>
                                <td width="5%"><i class="fa fa-shopping-cart"></i></td>
                                <td>{{ $var->getId() }} {{ $var->getDescripcion() }}
                                <small>&nbsp;({{ $var->getCategoria()->getNombre() }})</small></td>
                                <td class="level-right">
                                   $ {{ number_format($var->getPrecio(), 2, ',', '.') }}
                                </td>
                                @php
                                    $total+=$var->getPrecio()
                                @endphp
                            </tr>
                            @endforeach
                            <tr class="is-selected">
                                <td width="5%"><i class="fa fa-shopping-cart"></i></td>
                                <td>Total del carrito</td>
                                <td class="level-right">
                                   $ {{ number_format($total, 2, ',', '.') }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="column is-6">
        <div class="card ">
            <header class="card-header">
                <p class="card-header-title">
                    Tarjetas del cliente
                </p>
            </header>
            <div class="card-table">
                <div class="content">
                    <table class="table is-fullwidth is-striped">
                        <tbody>
                            @foreach ($tarjetas as $var)
                            <tr>
                                <td width="5%"><i class="fa fa-credit-card"></i></td>
                                <td>{{ $var->getNombre() }} {{ $var->getNumero() }}</td>
                                <td class="level-right">
                                    <button class="button is-small is-primary"
                                        id="tarjeta_{{ $var->getId() }}"
                                        monto="{{ $var->getDisponible() }}"
                                        onclick="seleccionar({{ $var->getId() }})">
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
<script>
    let total={{ $total }}
    let carrito_id={{ $carrito->getId() }}
    let tarjeta=null
    function seleccionar(tarjetaId){
        let boton=document.getElementById(`tarjeta_${tarjetaId}`)
        
        if (tarjeta != null && tarjeta == tarjetaId) {
            boton.innerHTML='Seleccionar'
            boton.classList.toggle('is-primary')
            boton.classList.toggle('is-info')
            boton.parentElement.parentElement.classList.toggle('has-background-light')
            tarjeta=null
            let info=document.getElementById('venta-informacion')
            info.innerHTML=null
            return
        }

        if (tarjeta != null){
            alert('Seleccione solo una tarjeta')
            return
        }

        if (boton.innerHTML.trim() == "Seleccionar"){
            boton.innerHTML='Seleccionado'
            tarjeta=tarjetaId
            let info=document.getElementById('venta-informacion')
            info.innerHTML=null
            info.innerHTML=`<a href="/venta/guardar?carrito_id=${carrito_id}&tarjeta_id=${tarjetaId}" class="button is-warning">Pagar</a>`
        }else{
            boton.innerHTML='Seleccionar'
        }
        boton.classList.toggle('is-primary')
        boton.classList.toggle('is-info')
        boton.parentElement.parentElement.classList.toggle('has-background-light')
    }

</script>

@endsection