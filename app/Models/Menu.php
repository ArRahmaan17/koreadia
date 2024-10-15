<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'route', 'icon', 'place', 'parent'];

    public function roles(): HasMany
    {
        return $this->hasMany(RoleMenu::class, 'menu_id', 'id');
    }

    public function child(): HasMany
    {
        return $this->hasMany(Menu::class, 'parent', 'id');
    }
}
