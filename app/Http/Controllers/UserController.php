<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRegisterPostRequest;
use Illuminate\Support\Facades\Hash;
use App\Models\User as UserModel;

class UserController extends Controller
{
    //ユーザ登録画面表示
    public function index()
    {
        return view('user.register');
    }
    
    //ユーザー登録
    public function register(UserRegisterPostRequest $request)
    {
    // validate済
    // データ取得
    $datum = $request->validated();
    $datum['password'] = Hash::make($datum['password']);
    $user = UserModel::create($datum);
        //
        $request->session()->flash('user_registered', true);
        return redirect()->intended('/');
    }
    
}