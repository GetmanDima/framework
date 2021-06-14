<?php


namespace App\Controllers\Auth;


use App\Controllers\AppController;
use App\Models\User;
use Core\HashCreator;
use Core\Mailer;
use Core\SessionMessage;
use Rakit\Validation\Validation;

class RegisterController extends AppController
{
    use SessionMessage;
    use HashCreator;

    protected string $failRedirectTo = '/register';

    public function __construct()
    {
        $this->middleware(['guest']);
    }

    public function showRegistrationForm()
    {
        $title = 'Register';
        $formErrors = $this->getFormErrors();

        $this->render(
            'auth/register',
            'templates/default',
            compact('title', 'formErrors')
        );
    }

    public function register()
    {
        $this->validate();

        $name = $this->request->post('name');
        $email = $this->request->post('email');
        $password = $this->request->post('password');
        $token = $this->getTokenForUser($email, $password);

        User::register(compact('name', 'email', 'password') + ['remember_token' => $token]);

        $this->sendVerifyMessage($token);

        $this->setAlertMessage(
            'success',
            'Registration completed successfully! Please, follow the link in email message to verify your email'
        );

        redirect('/login');
    }

    /**
     * @param string $token
     */
    public function sendVerifyMessage(string $token)
    {
        $name = $this->request->post('name');
        $email = $this->request->post('email');

        $isHtml = true;
        $subject = 'Verify your email';
        $body = "Hello $name. To verify your email follow the link <a href='"
            . APP_URL
            . '/verify/'
            . $token
            . "'>Verify Link</a>";

        $mail = new Mailer();
        $mail->setMessageData($isHtml, $subject, $body);
        $mail->send($email);
    }

    /**
     * @return Validation
     */
    protected function validation(): Validation
    {
        return $this->request->validation(['post'], [
            'name' => ['required', 'alpha_spaces', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:User,email'],
            'password' => ['required', 'min:8', 'max:255'],
            'confirmPassword' => ['required', 'same:password']
        ]);
    }
}