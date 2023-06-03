<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class ShoppingList extends Model
{
    use HasFactory;

    // 複数代入不可能な属性
    protected $guarded = ['id'];
    /**
     * 名前昇順ソート
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function sortedByName()
    {
        return static::query()->orderBy('name', 'asc');
    }
}    