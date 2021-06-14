<?php


namespace App\Controllers;


use Core\Controller;
use Illuminate\Database\Eloquent\Model;

class AppController extends Controller
{
    /**
     * @return bool
     */
    public function isUserLogged(): bool
    {
        return $this->request->session()->get('user') !== null;
    }

    /**
     * @return Model|null
     */
    public function getLoggedUser(): ?Model
    {
        return $this->request->session()->get('user');
    }
}