<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entities\Producto;
use App\Entities\Categoria;
use App\Entities\Marca;
use App\Services\Doctrine\ProductoDoctrine;
use Exception;
use Illuminate\Support\Facades\Redirect;
use LaravelDoctrine\ORM\Facades\EntityManager;

class ProductoController extends Controller
{
    function index(Request $r){
        $ps=new ProductoDoctrine();
        return view('crud.productos',[
            'list' => $ps->listarProductos(),
            'get' => $r->id ? $ps->obtenerProducto($r->id) : null,
            'categorias' => $ps->listarCategorias(),
            'marcas' => $ps->listarMarcas(),
        ]);
    }

    function save(Request $r){
        $ps=new ProductoDoctrine();
        $categoria=$ps->obtenerCategoria($r->categoria);
        $marca=$ps->obtenerMarca($r->marca);
        if ($r->id) { 
            $ps->modificarProducto($r->id, $r->descripcion, $r->precio, $categoria, $marca);
        }else{
            $ps->crearProducto($r->descripcion, $r->precio, $categoria, $marca);
        }
        return Redirect::route('productos');
    }

    function remove(Request $r){
        $ps=new ProductoDoctrine();
        try {
            $ps->borrarProducto($r->id);
        } catch (Exception $e) {
            return Redirect::back()->withErrors(['Error']);
        }
        return Redirect::route('productos');
    }
}
