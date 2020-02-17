<?php

namespace App\Http\Controllers;

use App\Entities\Carrito;
use Illuminate\Http\Request;
use App\Entities\Cliente;
use App\Entities\Producto;
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
}
