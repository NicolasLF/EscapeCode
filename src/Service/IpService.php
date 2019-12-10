<?php


namespace App\Service;

use Symfony\Component\HttpFoundation\RequestStack;

class IpService
{
    protected $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function get()
    {
        return $this->requestStack->getCurrentRequest()->getClientIp();
    }
}