<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NavigationItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NavigationController extends Controller{
    public function getUserMenu(Request $request){
        $user = $request->user();

        // Obtener elementos principales (sin padre) ordenados
        $menuItems = NavigationItem::whereNull('parent_id')
            ->orderBy('order')
            ->get();

        $filteredMenu = $this->formatMenuForUser($menuItems, $user);

        return response()->json([
            'success' => true,
            'menu' => $filteredMenu
        ]);
    }

    private function formatMenuForUser($items, $user){
        $branch = [];

        foreach ($items as $item) {
            // DEPURACIÓN: Miremos qué evalúa cada ítem
            Log::info("Evaluando ruta: {$item->name} | Permiso requerido: {$item->permission_name} | ¿Tiene permiso?: " . ($user->can($item->permission_name) ? 'SÍ' : 'NO'));
            // Verificar si el usuario tiene el permiso para esta ruta
            if ($user->can($item->permission_name) || $user->hasRole('admin')) {
                
                // Obtenemos los hijos directamente usando la relación del modelo
                $children = $item->children; 

                $formattedChildren = $children->isNotEmpty() 
                    ? $this->formatMenuForUser($children, $user) 
                    : [];

                // Si es un menú padre pero sus hijos están vacíos porque no tiene permisos, lo ocultamos
                if ($children->isNotEmpty() && empty($formattedChildren)) {
                    continue;
                }

                $branch[] = [
                    'id' => $item->id,
                    'name' => $item->name,
                    'path' => $item->path,
                    'icon' => $item->icon,
                    'children' => $formattedChildren
                ];
            }
        }

        return $branch;
    }
}
