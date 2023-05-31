<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\ShoppingListRegisterPostRequest;
use App\Models\ShoppingList as ShoppingListModel;
use App\Models\CompletedShoppingListModel as CompletedShoppingListModel;

class CompletedShoppingListController extends Controller
{
    /**
     * 「完了タスク」の一覧を表示する
     *
     * @return \Illuminate\View\View
     */
    public function list()
    {
        $completedTasks = CompletedShoppingListModel::where('user_id', Auth::id())->paginate(3);
        return view('shopping_list.completed_list', ['list' => $shopping_list_task]);
    }   
}