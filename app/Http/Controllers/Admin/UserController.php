<?php
declare(strict_types=1);
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User as UserModel;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * ユーザの一覧 を表示する
     * 
     * @return \Illuminate\View\View
     */
    public function list()
    {
        $group_by_column = ['users.id', 'users.name'];
        $list = UserModel::select($group_by_column)
                         ->selectRaw('COUNT(completed_shopping_lists.id) as shopping_list_count')
                         ->leftJoin('completed_shopping_lists', 'users.id', '=', 'completed_shopping_lists.user_id')
                         ->groupBy($group_by_column)
                         ->orderBy('users.id')
                         ->get();
//echo "<pre>\n";
//var_dump($list->toArray()); exit;
        return view('admin.user.list', ['users' => $list]);
    }

    /**
     * 管理画面を表示する
     * 
     * @return \Illuminate\View\View
     */
    public function top()
    {
        return view('admin.top');
    }
}