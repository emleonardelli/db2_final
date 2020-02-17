<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entities\Marca;
use Illuminate\Support\Facades\Redirect;
use LaravelDoctrine\ORM\Facades\EntityManager;

class MarcaController extends Controller
{
    function index(Request $r){
        $marcas=EntityManager::getRepository(Marca::class);

        return view('crud.marcas',[
            'list' => $marcas->findAll(),
            'get' => $r->id ? $marcas->find($r->id) : null
        ]);
    }

    function save(Request $r){
        $marca=null;
        if ($r->id) { 
            $marcas=EntityManager::getRepository(Marca::class);
            $marca=$marcas->find($r->id);
            $marca->setNombre($r->nombre);
            $marca->setDescripcion($r->descripcion);
            EntityManager::persist($marca);
            EntityManager::flush();
        }else{
            $marca=new Marca($r->nombre, $r->descripcion);
            EntityManager::persist($marca);
            EntityManager::flush();
        }
        return Redirect::route('marcas');
    }

    function remove(Request $r){
        $marcas=EntityManager::getRepository(Marca::class);
        $marca=$marcas->find($r->id);
        
        try {
            EntityManager::remove($marca);
            EntityManager::flush();
        } catch (\Throwable $th) {
            return Redirect::back()->withErrors(['La marca tiene productos asignados']);
        }
        return Redirect::route('marcas');
    }
}
