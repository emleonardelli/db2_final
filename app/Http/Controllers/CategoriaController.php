<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Doctrine\ProductoDoctrine;
use Exception;
use Illuminate\Support\Facades\Redirect;

class CategoriaController extends Controller
{
    protected $ps;

    public function __construct(){
        $this->ps=new ProductoDoctrine();
    }

    function index(Request $r){
        return view('crud.categorias',[
            'list' => $this->ps->listarCategorias(),
            'get' => $r->id ? $this->ps->obtenerCategoria($r->id) : null
        ]);
    }

    function save(Request $r){
        if ($r->id) { 
            $this->ps->modificarCategoria($r->id, $r->nombre, $r->descripcion);
        }else{
            $this->ps->crearCategoria($r->nombre, $r->descripcion);
        }
        return Redirect::route('categorias');
    }

    function remove(Request $r){
        try {
            $this->ps->borrarCategoria($r->id);
        } catch (Exception $e) {
            return Redirect::back()->withErrors([$e->getMessage()]);
        }
        return Redirect::route('categorias');
    }
}
