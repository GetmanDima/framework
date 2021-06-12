<?php


namespace App\Controllers\Auth;


use App\Controllers\AppController;
use App\Models\User;
use Core\Mailer;
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
        $title = 'Register';
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
        $token = $this->getVerifyEmailHash();

        User::create(compact('name', 'email', 'password') + ['remember_token' => $token]);

        $this->sendConfirmMessage($token);

        $this->request->session()->setFlash(
            'message',
            [
                'type' => 'success',
                'text' => 'Registration completed successfully! Please, follow the link in email message to verify your email'
            ]
        );

        redirect('/login');
    }

    public function sendConfirmMessage($token)
    {
        $name = $this->request->post('name');
        $email = $this->request->post('email');

        $isHtml = true;
        $subject = 'Verify your email';
        $body = "Hello $name. To verify your email follow the link <a href='"
            . APP_URL
            . '/verify?token='
            . $token
            . "'>Verify Link</a>";

        $mail = new Mailer();
        $mail->setMessageData($isHtml, $subject, $body);
        $mail->send($email);
    }

    public function getVerifyEmailHash()
    {
        $email = $this->request->post('email');
        $password = $this->request->post('password');

        return password_hash($email . $password . time(), PASSWORD_BCRYPT);
    }
}