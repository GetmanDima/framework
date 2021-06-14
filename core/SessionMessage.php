<?php


namespace Core;


trait SessionMessage
{
    /**
     * @param string $type
     * @param string $text
     */
    private function setAlertMessage(string $type, string $text)
    {
        $this->request->session()->setFlash(
            'message',
            ['type' => $type, 'text' => $text]
        );
    }

    /**
     * @return string|null
     */
    private function getAlertMessage()
    {
        return $this->request->session()->getFlash('message');
    }

    /**
     * @return array
     */
    private function getFormErrors(): array
    {
        $errors = [];
        $session = $this->request->session();

        if ($session->hasFlash('form-errors')) {
            $errors = $session->getFlash('form-errors');
        }

        return $errors;
    }
}