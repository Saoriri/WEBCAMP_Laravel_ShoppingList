<?php
declare(strict_types=1);
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminLoginPostRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller 
{
    //トップページ表示
   public function index()
    {
        return view('admin.index');
    }
    
    //ログイン処理
    public function login(AdminLoginPostRequest $request)
    {
        // validate済

        // データの取得
        $datum = $request->validated();
        //var_dump($datum); exit;

        // 認証
        if (Auth::attempt($datum) === false) {
            return back()
                   ->withInput() // 入力値の保持
                   ->withErrors(['auth' => 'emailかパスワードに誤りがあります。',]) 
                   ;
        }

        //
        $request->session()->regenerate();
        return redirect()->intended('/shopping_list/list');
    }
}