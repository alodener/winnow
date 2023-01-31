<?php

namespace App\Listeners;
use Illuminate\Auth\Events\Login;

class LogSuccessfulLogin {

  /**
   * Create the event listener.
   *
   * @return void
   */
  public function __construct(){


  }

 /**
  * Handle the event.
  *
  * @param  Login $event
  * @throws \Exception
  */

  public function handle(Login $event){
    $user = $event->user;

    $user->ip = request()->getClientIp();
    $user->save();

  }
}
