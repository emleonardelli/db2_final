<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Doctrine\ProductoDoctrine;
use Exception;
use Illuminate\Support\Facades\Redirect;

class ProductoController extends Controller
{
    protected $ps;

    public function __construct(){
        $this->ps=new ProductoDoctrine();
    }

    function index(Request $r){
        return view('crud.productos',[
            'list' => $this->ps->listarProductos(),
            'get' => $r->id ? $this->ps->obtenerProducto($r->id) : null,
            'categorias' => $this->ps->listarCategorias(),
            'marcas' => $this->ps->listarMarcas(),
        ]);
    }

    function save(Request $r){
        $categoria=$this->ps->obtenerCategoria($r->categoria);
        $marca=$this->ps->obtenerMarca($r->marca);
        if ($r->id) { 
            $this->ps->modificarProducto($r->id, $r->descripcion, $r->precio, $categoria, $marca);
        }else{
            $this->ps->crearProducto($r->descripcion, $r->precio, $categoria, $marca);
        }
        return Redirect::route('productos');
    }

    function remove(Request $r){
        try {
            $this->ps->borrarProducto($r->id);
        } catch (Exception $e) {
            return Redirect::back()->withErrors(['Error']);
        }
        return Redirect::route('productos');
    }
}
