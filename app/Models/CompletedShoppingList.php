<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompletedShoppingList extends Model
{
    use HasFactory;
    
    /**
     * 複数代入不可能な属性
     */
    protected $guarded = [];

    /**
     * 名前昇順と購入日昇順ソート
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSortedByNameAndDate($query)
    {
        return $query->orderBy('name', 'asc')->orderBy('created_at', 'asc');
    }
}
