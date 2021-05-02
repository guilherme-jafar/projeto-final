<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

//Route::post('/broadcasting/auth', function(Illuminate\Http\Request $req) {
//    if($req->channel_name == 'presence-global'){return 'global';}
//    return abort(403);
//});




Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('room.{sessaoId}', function ($sessao,$user,$type) {

    if ($user->canJoinRoom($sessao)) {
        return ['id'=>$user['id'], 'name' => $user['nome'] ,'sessao' => $sessao, "type" => $type];
    }

});
