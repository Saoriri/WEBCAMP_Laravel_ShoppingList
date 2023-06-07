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

class ShoppingListController extends Controller
{
    //一覧用の Illuminate\Database\Eloquent\Builder インスタンスの取得
    protected function getListBuilder()
    {
        return ShoppingListModel::where('user_id', Auth::id())
                    ->orderBy('name');
    }
    
    //「買うもの」一覧ページの表示
    public function list()
    {
        // 1Pageの表示アイテム数
        $per_page = 3;
        
        // 一覧の取得
        $shopping_list = $this->getListBuilder()->orderBy('name')->paginate($per_page);
                     
        return view('shopping_list.list',['list' => $shopping_list]);
    }
    
    //「買うもの」の登録
    public function register(ShoppingListRegisterPostRequest $request)
    {
        
        // validate済みのデータの取得
        $datum = $request->validated();
        
        // user_id の追加
        $datum['user_id'] = Auth::id();
        
        // 「登録日」の追加
        $datum['register'] = date('Y-m-d');
        
        // テーブルへのINSERT
        try {
            $r = ShoppingListModel::create($datum);
        } catch(\Throwable $e) {
            // XXX 本当はログに書く等の処理をする。今回は一端「出力する」だけ
            echo $e->getMessage();
            exit;
        }

        // 「買うもの」登録成功
        $request->session()->flash('front.shopping_list_register_success', true);

        //
        return redirect('/shopping_list/list');
    }
        
    public function index()
    {
        $sortedLists = ShoppingListModel::orderBy('name')->get();

        // 取得したソート済みのリストを処理するなどのロジックを記述

        return view('view', ['sortedLists' => $sortedLists]);
    }

    //「単一のshopping_list_list」Modelの取得
    protected function getShoppingListModel($shopping_list_id)
    {
        // shopping_list_idのレコードを取得する
        $shopping_list_list = ShoppingListModel::find($shopping_list_id);
        if ($shopping_list_list === null) {
            return null;
        }
        // 本人以外のshopping_list_listならNGとする
        if ($shopping_list_list->user_id !== Auth::id()) {
            return null;
        }
        //
        return $shopping_list_list;
    }

    //「単一のshopping_list_list」の表示
    protected function singleShoppingListRender($shopping_list_id, $template_name)
    {
        // $shopping_list_idのレコードを取得する
        $shopping_list_list = $this->getShoppingListModel($shopping_list_id);
        if ($shopping_list_list === null) {
            return redirect('/shopping_list/list');
        }

        // テンプレートに「取得したレコード」の情報を渡す
        return view($template_name, ['shopping_list_list' => $shopping_list_list]);
    }
    
    //削除処理
    public function delete(Request $request, $shopping_list_id)
    {
        // shopping_list_idのレコードを取得する
        $shopping_list_list = $this->getShoppingListModel($shopping_list_id);

        // 「買うもの」を削除する
        if ($shopping_list_list !== null) {
            $shopping_list_list->delete();
            $request->session()->flash('front.shopping_list_delete_success', true);
        }

        // 一覧に遷移する
        return redirect('/shopping_list/list');
    }
    
    //「買うもの」の完了
   public function complete(Request $request, $shopping_list_id)
    {
    // $shopping_list_idのレコードを取得する
    $shopping_list_list = $this->getShoppingListModel($shopping_list_id);

    // レコードが存在しない場合はリダイレクトする
    if ($shopping_list_list === null) {
        return redirect('/shopping_list/list');
    }
        /* 「買うもの」を完了テーブルに移動させる */
        try {
            // トランザクション開始
            DB::beginTransaction();

            // shopping_list_idのレコードを取得する
            $shopping_list_list = $this->getShoppingListModel($shopping_list_id);
            if ($shopping_list_list === null) {
                // shopping_list_idが不正なのでトランザクション終了
                throw new \Exception('');
            }

            // shopping_lists側を削除する
            if (!$shopping_list_list->delete()) {
                throw new \Exception('Failed to delete shopping list list.');
            }

            // completed_shopping_lists側にinsertする
            $dask_datum = $shopping_list_list->toArray();
            unset($dask_datum['created_at']);
            unset($dask_datum['updated_at']);
            $r = CompletedShoppingListModel::create($dask_datum);
            if ($r === null) {
                throw new \Exception('Failed to insert completed shopping list.');
            }

            // トランザクション終了
            DB::commit();
            // 完了メッセージ出力
            $request->session()->flash('front.shopping_list_completed_success', true);
        } catch(\Throwable $e) {
            // トランザクション異常終了
            DB::rollBack();
            // 完了失敗メッセージ出力
            $request->session()->flash('front.shopping_list_completed_failure', true);
        }

        // 一覧に遷移する
        return redirect('/shopping_list/list');
    }
}