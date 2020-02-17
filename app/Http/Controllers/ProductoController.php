<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entities\Producto;
use App\Entities\Categoria;
use App\Entities\Marca;
use Illuminate\Support\Facades\Redirect;
use LaravelDoctrine\ORM\Facades\EntityManager;

class ProductoController extends Controller
{
    function index(Request $r){
        $productos=EntityManager::getRepository(Producto::class);
        $categorias=EntityManager::getRepository(Categoria::class);
        $marcas=EntityManager::getRepository(Marca::class);
        return view('crud.productos',[
            'list' => $productos->findAll(),
            'get' => $r->id ? $productos->find($r->id) : null,
            'categorias' => $categorias->findAll(),
            'marcas' => $marcas->findAll(),
        ]);
    }

    function save(Request $r){
        $producto=null;
        $categoria=EntityManager::getRepository(Categoria::class)->find($r->categoria);
        $marca=EntityManager::getRepository(Marca::class)->find($r->marca);
        if ($r->id) { 
            $productos=EntityManager::getRepository(Producto::class);
            $producto=$productos->find($r->id);
            $producto->setDescripcion($r->descripcion);
            $producto->setPrecio($r->precio);
            $producto->setCategoria($categoria);
            $producto->setMarca($marca);
        }else{
            $producto=new Producto($r->descripcion, $r->precio, $categoria, $marca);
        }
        EntityManager::persist($producto);
        EntityManager::flush();
        return Redirect::route('productos');
    }

    function remove(Request $r){
        $productos=EntityManager::getRepository(Producto::class);
        $producto=$productos->find($r->id);
        try {
            EntityManager::remove($producto);
            EntityManager::flush();
        } catch (\Throwable $th) {
            return Redirect::back()->withErrors(['Error']);
        }
        return Redirect::route('productos');
    }
}
