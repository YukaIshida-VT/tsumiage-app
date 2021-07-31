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
         }else{
            $user = new User();
            //ユーザーに必要な情報
            $user->name = $twitterUser->getName();
            $user->email = $twitterUser->id;
            $user->password = md5(Str::uuid());
            $user->avatar = $twitterUser->getAvatar();
            $user->nickname = $twitterUser->getNickname();
            $user->save();
            
         }
         Log::info('Twitterから取得しました。', ['user' => $twitterUser]);
         Auth::login($user);
         return redirect('/');
     }

     public function logout()
     {
         Auth::logout();
         return redirect('/');
     }
}
