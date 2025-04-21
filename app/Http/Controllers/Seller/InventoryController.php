<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        // Obtener productos activos con su categoría y stock
        $products = Product::where('is_active', true)
            ->with('category:id,name') // Carga eficiente de categoría (solo id y nombre)
            ->select('id', 'name', 'category_id', 'selling_price', 'quantity') // Selecciona solo lo necesario
            ->latest()
            ->paginate(15);

        return view('seller.inventory.index', compact('products'));
    }
}
