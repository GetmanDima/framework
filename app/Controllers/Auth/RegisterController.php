<?php


namespace App\Controllers\Auth;


use App\Controllers\AppController;
use App\Models\User;
use Rakit\Validation\Validation;

class RegisterController extends AppController
{
    protected string $failRedirectTo = '/register';

    public function __construct()
    {
        $this->middleware(['guest']);
    }

    /**
     * @return Validation
     */
    public function validation(): Validation
    {
        return $this->request->validation(['post'], [
            'name' => ['required', 'alpha_spaces', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:User,email'],
            'password' => ['required', 'min:8', 'max:255'],
            'confirmPassword' => ['required', 'same:password']
        ]);
    }

    public function showRegistrationForm()
    {
        $title = 'Sign Up';
        $session = $this->request->session();
        $errors = [];

        if ($session->hasFlash('form-errors')) {
            $errors = $session->getFlash('form-errors');
        }

        $this->render(
            'auth/register',
            'templates/default',
            compact('title', 'errors')
        );
    }

    public function register()
    {
        $this->validate();

        $name = $this->request->post('name');
        $email = $this->request->post('email');
        $password = $this->request->post('password');

        User::create(compact('name', 'email', 'password'));

        $this->request->session()->setFlash(
            'message',
            ['type' => 'success', 'text' => 'Registration completed successfully!']
        );

        redirect('/login');
    }
}