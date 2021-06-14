<?php


namespace Core;


trait HashCreator
{
    /**
     * @param string $password
     * @return false|string|null
     */
    private function getPasswordHash(string $password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    /**
     * @param string $email
     * @param string $password
     * @return false|string|null
     */
    private function getTokenForUser(string $email, string $password)
    {
        $token = password_hash($email . $password . time(), PASSWORD_BCRYPT);

        return str_replace(['.', '/'], '', $token);
    }
}