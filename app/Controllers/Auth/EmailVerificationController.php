<?php


namespace App\Controllers\Auth;


use App\Controllers\AppController;
use App\Models\User;

class EmailVerificationController extends AppController
{
    public function verify()
    {
        $token = $this->request->get('token');

        $user = User::findOne(['remember_token' => $token]);

        if ($user && $user->email_verified_at === null) {
            $user->email_verified_at = date('Y-m-d H:i:s');
            $user->store();

            $this->request->session()->setFlash(
                'message',
                ['type' => 'success', 'text' => 'Your email was verified']
            );
        } else {
            echo 'error 404';
        }

        if ($this->isUserLogged()) {
            redirect('/');
        } else {
            redirect('/login');
        }
    }
}