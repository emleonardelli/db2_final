<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entities\Producto;
use App\Entities\Categoria;
use Illuminate\Support\Facades\Redirect;
use LaravelDoctrine\ORM\Facades\EntityManager;

class ProductoController extends Controller
{
    function index(Request $r){
        $productos=EntityManager::getRepository(Producto::class);
        $categorias=EntityManager::getRepository(Categoria::class);
        return view('crud.productos',[
            'list' => $productos->findAll(),
            'get' => $r->id ? $productos->find($r->id) : null,
            'categorias' => $categorias->findAll(),
        ]);
    }

    function save(Request $r){
        $producto=null;
        $categorias=EntityManager::getRepository(Categoria::class);
        $categoria=$categorias->find($r->categoria);
        if ($r->id) { 
            $productos=EntityManager::getRepository(Producto::class);
            $producto=$productos->find($r->id);
            $producto->setDescripcion($r->descripcion);
            $producto->setPrecio($r->precio);
            $producto->setCategoria($categoria);
        }else{
            $producto=new Producto($r->descripcion, $r->precio, $categoria);
        }
        EntityManager::persist($producto);
        EntityManager::flush();
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
