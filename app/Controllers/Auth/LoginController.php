<?php


namespace App\Controllers\Auth;


use App\Controllers\AppController;
use App\Models\User;
use Core\SessionMessage;
use Rakit\Validation\Validation;

class LoginController extends AppController
{
    use SessionMessage;

    protected string $failRedirectTo = '/login';

    public function __construct()
    {
        $this->middleware(['guest'], 'showLoginForm');
        $this->middleware(['guest'], 'login');
        $this->middleware(['auth'], 'logout');
    }

    public function showLoginForm()
    {
        $title = 'Login';
        $alertMessage = $this->getAlertMessage();
        $formErrors = $this->getFormErrors();

        $this->render(
            'auth/login',
            'templates/default',
            compact('title', 'formErrors', 'alertMessage')
        );
    }

    public function login()
    {
        $this->validate();

        $email = $this->request->post('email');
        $password = $this->request->post('password');

        $user = User::login($email, $password);

        if ($user === null) {
            $this->setAlertMessage('danger', 'User with such email and password does not exist!');
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

    /**
     * @return Validation
     */
    protected function validation(): Validation
    {
        return $this->request->validation(['post'], [
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'min:8', 'max:255'],
        ]);
    }
}