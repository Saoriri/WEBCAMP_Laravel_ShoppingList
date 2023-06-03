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

class CompletedShoppingListController extends Controller
{
    /**
     * 「買うもの」の一覧を表示する
     *
     * @return \Illuminate\View\View
     */
    public function list()
    {
        $completed_shopping_list = CompletedShoppingListModel::where('user_id', Auth::id())->sortedByNameAndDate()->paginate(3);
  
        return view('shopping_list.completed_shopping_list', ['list' => $completed_shopping_list]);
    }
}