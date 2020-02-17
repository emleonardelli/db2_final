<?php

namespace App\Http\Controllers;

use App\Entities\Carrito;
use Illuminate\Http\Request;
use App\Entities\Cliente;
use App\Entities\Producto;
use App\Entities\Tarjeta;
use Illuminate\Support\Facades\Redirect;
use LaravelDoctrine\ORM\Facades\EntityManager;

class SaleController extends Controller
{
    function carrito(Request $r){
        $clientes=EntityManager::getRepository(Cliente::class)->findAll();
        $productos=EntityManager::getRepository(Producto::class)->findAll();
        $carritos=EntityManager::getRepository(Carrito::class)->findAll();
        return view('carrito',[
            'producto_list' => $productos,
            'cliente_list' => $clientes,
            'list' => $carritos,
        ]);
    }

    function saveCarrito(Request $r){
        $cliente=EntityManager::getRepository(Cliente::class)->find($r->cliente_id);
        $productosId=explode(',',$r->productos);
        $productos=[];
        $carrito=new Carrito($cliente);
        foreach ($productosId as $var) {
            $producto=EntityManager::getRepository(Producto::class)->find($var);
            $carrito->addProducto($producto);
        }
        EntityManager::persist($carrito);
        EntityManager::flush();
        return Redirect()->route('carrito');
    }

    function deleteCarrito(Request $r){
        $carrito=EntityManager::getRepository(Carrito::class)->find($r->id);
        EntityManager::remove($carrito);
        EntityManager::flush();
        return Redirect()->route('carrito');
    }

    function payCarrito(Request $r){
        $carrito=EntityManager::getRepository(Carrito::class)->find($r->carrito_id);
        $cliente=EntityManager::getRepository(Cliente::class)
            ->find($carrito->getCliente()->getId());
        $tarjetas=EntityManager::getRepository(Tarjeta::class)
            ->findBy(['cliente' => $cliente->getId()]);
        
        return view('venta',[
            'carrito' => $carrito,
            'cliente' => $cliente,
            'tarjetas' => $tarjetas
        ]);
    }

    function savePayment(Request $r){
        $carrito=EntityManager::getRepository(Carrito::class)->find($r->carrito_id);
        $tarjeta=EntityManager::getRepository(Tarjeta::class)->find($r->tarjeta_id);

        $total=0;
        foreach ($carrito->getProductos() as $var) {
            $total+=$var->getPrecio();
        }

        if ($total > $tarjeta->getDisponible()){
            return Redirect::back()->withErrors(['Limite superado']);
        }

        $tarjeta->setDisponible($tarjeta->getDisponible()-$total);
        EntityManager::persist($tarjeta);
        EntityManager::flush();

        $descripcion='
            Operacion Nro: '.$carrito->getId().' <br>
            Cliente: '.$carrito->getCliente()->getNombre().' '.$carrito->getCliente()->getApellido().',
            Email: '.$carrito->getCliente()->getEmail().'<br>
            Total de la compra: $ '.number_format($total, 2, ',', '.').'
            <br><br>
            Listado de productos
            <br>
        ';
        
        foreach ($carrito->getProductos() as $var) {
            $descripcion.=$var->getId().' '.
                $var->getDescripcion().' - $'.
                number_format($var->getPrecio(), 2, ',', '.').'<br>';
        }

        $carrito->setPagado(1);
        $carrito->setFecha(date('Y-m-d h:i:s'));
        $carrito->setDescripcion($descripcion);
        EntityManager::persist($carrito);
        EntityManager::flush();
        return Redirect()->route('ventas');
    }

    function payments(Request $r){
        $carritos=EntityManager::getRepository(Carrito::class)
            ->findBy(['pagado' => true]);

        return view('ventas', [
            'list' => $carritos
        ]);
    }
}
