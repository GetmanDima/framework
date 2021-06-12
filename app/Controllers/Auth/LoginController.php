<?php


namespace App\Controllers\Auth;


use App\Controllers\AppController;
use App\Models\User;
use Rakit\Validation\Validation;

class LoginController extends AppController
{
    protected string $failRedirectTo = '/login';

    public function __construct()
    {
        $this->middleware(['guest'], 'showLoginForm');
        $this->middleware(['guest'], 'login');
        $this->middleware(['auth'], 'logout');
    }

    /**
     * @return Validation
     */
    public function validation(): Validation
    {
        return $this->request->validation(['post'], [
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'min:8', 'max:255'],
        ]);
    }

    public function showLoginForm()
    {
        $title = 'Login';
        $session = $this->request->session();
        $message = $session->getFlash('message');
        $errors = [];

        if ($session->hasFlash('form-errors')) {
            $errors = $session->getFlash('form-errors');
        }

        $this->render(
            'auth/login',
            'templates/default',
            compact('title', 'errors', 'message')
        );
    }

    public function login()
    {
        $this->validate();

        $email = $this->request->post('email');
        $password = $this->request->post('password');

        $user = User::findByEmailAndPassword($email, $password);

        if ($user === null) {
            $this->request->session()->setFlash(
                'message',
                ['type' => 'danger', 'text' => 'User with such email and password does not exist!']
            );

            redirect('/login');
        } else {
            $this->request->session()->set('user', $user);
            redirect('/');
        }
    }

    public function logout()
    {
        $this->request->session()->remove('user');
        redirect('/login');
    }
}