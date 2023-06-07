<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\ShoppingListRegisterPostRequest;
use App\Models\ShoppingList as ShoppingListModel;
use App\Models\CompletedShoppingList as CompletedShoppingListModel;
use Carbon\Carbon;

class CompletedShoppingListController extends Controller
{
    /**
     * 「買うもの」の一覧を表示する
     *
     * @return \Illuminate\View\View
     */
    public function list()
    {
    $completed_shopping_list = CompletedShoppingListModel::where('user_id', Auth::id())
        ->orderBy('name', 'asc')
        ->orderBy('created_at', 'asc')
        ->paginate(3);

    // 完了日付のフォーマットを変更
    $completed_shopping_list->getCollection()->transform(function ($item) {
        $item->created_at = Carbon::parse($item->created_at)->format('Y/m/d');
        return $item;
    });

    return view('shopping_list.completed_shopping_list', ['list' => $completed_shopping_list]);
    }
}