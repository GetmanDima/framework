<?php


namespace App\Controllers\Auth;


use App\Controllers\AppController;
use App\Models\PasswordReset;
use App\Models\User;
use Core\HashCreator;
use Core\Mailer;
use Core\SessionMessage;
use Rakit\Validation\Validation;

class ForgotPasswordController extends AppController
{
    use SessionMessage;
    use HashCreator;

    public function __constructor()
    {
        $this->middleware(['guest']);
    }

    public function showForgotPasswordForm()
    {
        $title = 'Forgot password';
        $loggedUser = $this->getLoggedUser();
        $alertMessage = $this->getAlertMessage();
        $formErrors = $this->getFormErrors();

        $this->render(
            'auth/forgot_password',
            'templates/default',
            compact('title', 'loggedUser', 'alertMessage', 'formErrors')
        );
    }

    public function showResetPasswordForm($token)
    {
        $title = 'Reset password';
        $loggedUser = $this->getLoggedUser();
        $alertMessage = $this->getAlertMessage();
        $formErrors = $this->getFormErrors();

        $this->render(
            'auth/reset_password',
            'templates/default',
            compact('title', 'loggedUser', 'alertMessage', 'formErrors', 'token')
        );
    }

    public function sendResetMessage()
    {
        $validation = $this->sendResetMessageValidation();
        $this->validate($validation, '/password/reset');

        $email = $this->request->post('email');
        $user = User::where('email', $email)->first();
        $token = $this->getTokenForUser($user->email, $user->password);

        $this->removeOldTokenRecords($email);
        $this->createNewTokenRecord($email, $token);

        $isHtml = true;
        $subject = 'Reset password';
        $body = "Hello $user->name. To reset your password follow the link <a href='"
            . APP_URL
            . '/password/reset/'
            . $token
            . "'>Reset Link</a>";

        $mail = new Mailer();
        $mail->setMessageData($isHtml, $subject, $body);
        $mail->send($email);

        redirect('/password/reset');
    }

    public function reset()
    {
        $token = $this->request->post('token');
        $password = $this->request->post('password');

        $validation = $this->resetValidation();
        $this->validate($validation, "/password/reset/$token");

        $passwordReset = PasswordReset::where('token', $token)->first();

        if ($passwordReset !== null) {
            $this->setNewPassword($passwordReset->email, $password);

            $this->setAlertMessage('success', 'Password reset successfully!');
            redirect('/login');
        } else {
            $this->setAlertMessage('danger', 'No such reset token exists!');
            redirect("/password/reset");
        }
    }

    /**
     * @param string $email
     */
    private function removeOldTokenRecords(string $email)
    {
        PasswordReset::where('email', $email)->delete();
    }

    /**
     * @param string $email
     * @param string $token
     */
    private function createNewTokenRecord(string $email, string $token)
    {
        PasswordReset::create(
            [
                'email' => $email,
                'token' => $token
            ]
        );
    }

    /**
     * @param string $email
     * @param string $password
     */
    private function setNewPassword(string $email, string $password)
    {
        $user = User::where('email', $email)->first();

        if ($user === null) {
            $this->setAlertMessage('danger', 'No user for reset such token!');
            redirect("/password/reset");
        }

        $user->password = $this->getPasswordHash($password);
        $user->save();
    }

    /**
     * @return Validation
     */
    private function resetValidation(): Validation
    {
        return $this->request->validation(['post'], [
            'password' => ['required', 'min:8', 'max:255'],
            'confirmPassword' => ['required', 'same:password']
        ]);
    }

    /**
     * @return Validation
     */
    private function sendResetMessageValidation(): Validation
    {
        return $this->request->validation(['post'], [
            'email' => ['required', 'email', 'max:255', 'exists:User,email'],
        ]);
    }
}