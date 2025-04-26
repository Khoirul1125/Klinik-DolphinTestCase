<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuManajemen extends Model
{
    use HasFactory;
    protected $table = 'menu_manajemen';

    protected $fillable = [
        'name',
        'route',
        'icon',
        'parent_id',
        'permission',
        'is_visible',
        'order'
    ];
    /**
     * Relasi ke sub-menu (anak dari menu utama).
     */
    public function children()
    {
        return $this->hasMany(MenuManajemen::class, 'parent_id')->orderBy('order');
    }
    /**
     * Relasi ke sub-menu yang terlihat.
     */
    public function visibleChildren()
    {
        return $this->hasMany(MenuManajemen::class, 'parent_id')->where('is_visible', true)->orderBy('order');
    }

    /**
     * Relasi ke menu induk (parent dari submenu).
     */
    public function parent()
    {
        return $this->belongsTo(MenuManajemen::class, 'parent_id');
    }

}
