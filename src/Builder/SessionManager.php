<?php

namespace App\Builder;

use Symfony\Component\HttpFoundation\Session\Session;

class SessionManager
{
    private $session;

    public function __construct()
    {
        $this->session = new Session();
        $this->startSession();
    }

    public function startSession()
    {
        $this->session->start();
    }

    public function getId()
    {
        return $this->session->getId();
    }

    public function setShuffledYes()
    {
        $this->session->set('shuffled', 1);
    }

    public function setShuffledNo()
    {
        $this->session->set('shuffled', null);
    }

    public function checkShuffle()
    {
        return $this->session->get('shuffled');
    }

    public function setShuffledData($data)
    {
        $this->session->set('shuffledData', $data);
    }

    public function getShuffledData()
    {
        return $this->session->get('shuffledData');
    }
}
