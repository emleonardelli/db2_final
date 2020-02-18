<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Doctrine\ClienteDoctrine;
use App\Services\Doctrine\ProductoDoctrine;
use App\Services\Doctrine\VentaDoctrine;
use Illuminate\Support\Facades\Redirect;
use Exception;

class SaleController extends Controller
{
    protected $vs;
    protected $cs;
    protected $ps;

    public function __construct(){
        $this->cs=new ClienteDoctrine();
        $this->ps=new ProductoDoctrine();
        $this->vs=new VentaDoctrine();
    }

    function carrito(Request $r){
        return view('carrito',[
            'producto_list' => $this->ps->listarProductos(),
            'cliente_list' => $this->cs->listarClientes(),
            'list' => $this->vs->listarCarritos(),
        ]);
    }

    function saveCarrito(Request $r){
        $cliente=$this->cs->obtenerCliente($r->cliente_id);
        $productos_id=explode(',',$r->productos);
        $this->vs->guardarCarrito($cliente, $productos_id);
        return Redirect()->route('carrito');
    }

    function deleteCarrito(Request $r){
        $this->vs->borrarCarrito($r->id);
        return Redirect()->route('carrito');
    }

    function payCarrito(Request $r){
        $carrito=$this->vs->obtenerCarrito($r->carrito_id);
        $cliente=$this->cs->obtenerCliente($carrito->getCliente()->getId());
        $tarjetas=$this->cs->listarTarjetas(['cliente' => $cliente->getId()]);
        
        return view('venta',[
            'carrito' => $carrito,
            'cliente' => $cliente,
            'tarjetas' => $tarjetas
        ]);
    }

    function savePayment(Request $r){
        $carrito=$this->vs->obtenerCarrito($r->carrito_id);
        $tarjeta=$this->cs->obtenerTarjeta($r->tarjeta_id);

        try {
            $this->vs->pagarCarrito($carrito, $tarjeta);
        } catch (Exception $e) {
            return Redirect::back()->withErrors([$e->getMessage()]);
        }
        return Redirect()->route('ventas');
    }

    function payments(Request $r){
        return view('ventas', [
            'list' => $this->vs->listarPagos()
        ]);
    }
}
