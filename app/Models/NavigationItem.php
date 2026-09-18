<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NavigationItem extends Model{
    use HasFactory;
    // Campos permitidos para asignación masiva
    protected $fillable = [
        'name',
        'path',
        'icon',
        'parent_id',
        'permission_name',
        'order',
    ];
    /**
     * Relación: Un elemento de navegación puede tener un elemento padre (para subrutas).
     */
    public function parent(){
        return $this->belongsTo(NavigationItem::class, 'parent_id');
    }

    /**
     * Relación: Un elemento de navegación puede tener varios elementos hijos (subrutas).
     */
    public function children(){
        return $this->hasMany(NavigationItem::class, 'parent_id')->orderBy('order');
    }
}
