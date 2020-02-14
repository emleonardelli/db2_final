<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entities\Categoria;
use Illuminate\Support\Facades\Redirect;
use LaravelDoctrine\ORM\Facades\EntityManager;

class CategoriaController extends Controller
{
    function index(Request $r){
        $categorias=EntityManager::getRepository(Categoria::class);

        return view('crud.categorias',[
            'list' => $categorias->findAll(),
            'get' => $r->id ? $categorias->find($r->id) : null
        ]);
    }

    function save(Request $r){
        $categoria=null;
        if ($r->id) { 
            $categorias=EntityManager::getRepository(Categoria::class);
            $categoria=$categorias->find($r->id);
            $categoria->setNombre($r->nombre);
            $categoria->setDescripcion($r->descripcion);
            EntityManager::persist($categoria);
            EntityManager::flush();
        }else{
            $categoria=new Categoria($r->nombre, $r->descripcion);
            EntityManager::persist($categoria);
            EntityManager::flush();
        }
        return Redirect::route('categorias');
    }

    function remove(Request $r){
        $categorias=EntityManager::getRepository(Categoria::class);
        $categoria=$categorias->find($r->id);
        EntityManager::remove($categoria);
        EntityManager::flush();
        return Redirect::route('categorias');
    }
}
