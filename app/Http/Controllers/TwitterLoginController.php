<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\User;


class TwitterLoginController extends Controller
{
    public function index()
    {
        if (Auth::user()) {
            // ログイン済みのユーザーはhome画面にリダイレクト
            return redirect('/home');
        } else {
            return view('twitterLogin')->with('title', 'ログイン | Tsumiage App');
        }
    }

    /**
       * Twitterの認証ページヘユーザーをリダイレクト
       *
       * @return \Illuminate\Http\Response
       */      
      public function redirectToProvider(){
        return Socialite::driver('twitter')->redirect();
     }   
    /**
     * Twitterからユーザー情報を取得(Callback先)
     *
     * @return \Illuminate\Http\Response
    */    
    public function handleProviderCallback()
    {
        try {
            $twitterUser = Socialite::driver('twitter')->user();
        } catch (Exception $e) {
            return redirect('auth/twitter');
        }
         if(User::where('email', $twitterUser->getId())->exists()){
            $user = User::where('email', $twitterUser->getId())->first();

            if ($twitterUser->getAvatar() != $user->avatar) {
                // ツイッターでアバターが更新されていた場合はデータベースの情報も更新する
                User::where('email', $twitterUser->getId())->update(['avatar' => $twitterUser->getAvatar()]);
            }
         }else{
            $user = new User();
            $user->name = $twitterUser->getName();
            $user->email = $twitterUser->getId();
            $user->password = md5(Str::uuid());
            $user->api_token = Str::random(32);
            $user->avatar = $twitterUser->getAvatar();
            $user->nickname = $twitterUser->getNickname();
            $user->save();

            $user->tsumiageItem()->create();
            $user->tsumiages()->create([
                'date' => '1980-01-01',
                'item' => 'dummy-item'
            ]);
         }
         Log::info('Twitterから取得しました。', ['user' => $twitterUser]);
         Auth::login($user);
         return redirect('/home');
     }

     public function logout()
     {
         Auth::logout();
         return redirect('/');
     }
}
