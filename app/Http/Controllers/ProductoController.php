<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entities\Producto;
use Illuminate\Support\Facades\Redirect;
use LaravelDoctrine\ORM\Facades\EntityManager;

class ProductoController extends Controller
{
    function index(Request $r){
        $productos=EntityManager::getRepository(Producto::class);

        return view('crud.productos',[
            'list' => $productos->findAll(),
            'get' => $r->id ? $productos->find($r->id) : null
        ]);
    }

    function save(Request $r){
        $producto=null;
        if ($r->id) { 
            $productos=EntityManager::getRepository(Producto::class);
            $producto=$productos->find($r->id);
            $producto->setDescripcion($r->descripcion);
            $producto->setCategoria($r->categoria);
            $producto->setPrecio($r->precio);
            EntityManager::persist($producto);
            EntityManager::flush();
        }else{
            $producto=new Producto($r->descripcion, $r->categoria, $r->precio);
            EntityManager::persist($producto);
            EntityManager::flush();
        }
        return Redirect::route('productos');
    }

    function remove(Request $r){
        $productos=EntityManager::getRepository(Producto::class);
        $producto=$productos->find($r->id);
        EntityManager::remove($producto);
        EntityManager::flush();
        return Redirect::route('productos');
    }
}
