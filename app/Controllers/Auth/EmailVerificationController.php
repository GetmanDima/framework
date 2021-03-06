<?php


namespace App\Controllers\Auth;


use App\Controllers\AppController;
use App\Models\User;
use Core\SessionMessage;

class EmailVerificationController extends AppController
{
    use SessionMessage;

    /**
     * @param string $token
     * @throws \Exception
     */
    public function verify(string $token)
    {
        $user = User::where('remember_token', $token)->first();

        if ($user !== null && $user->email_verified_at === null) {
            $user->email_verified_at = date('Y-m-d H:i:s');
            $user->save();

            $this->setAlertMessage('success', 'Your email was verified');
        } else {
            throw new \Exception('No user for a token: ' . $token, 404);
        }

        if ($this->isUserLogged()) {
            redirect('/');
        } else {
            redirect('/login');
        }
    }
}