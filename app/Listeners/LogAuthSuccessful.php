<?php

namespace App\Listeners;

use App\Models\User;

use Adldap\Laravel\Events\AuthenticationSuccessful;


class LogAuthSuccessful
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  AuthenticationSuccessful  $event
     * @return void
     */
    public function handle(AuthenticationSuccessful $event)
    {
        $belka=0;
        $groups = $event->user->getGroups();
        if (count($groups)){
            foreach($groups as $group){
                if ($group['name'][0]=='holiadmin'){
                    $event->model->role = User::ROLE_ADMIN;
                    $event->model->save();
                    $belka=1;
                }
            }
        }
        if (!$belka){
            $event->model->role = User::ROLE_USER;
            $event->model->save();
        }        
    }
}
