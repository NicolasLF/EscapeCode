<?php


namespace App\Service;


class BackdoorService
{
    const AUTHORIZED_IP = [
    ];

    /**
     * @var IpService
     */
    private $ipService;

    public function authorization()
    {

        /*------- Do not touch --------*/
        if ($this->ipService !== null && in_array($this->ipService->get(), self::AUTHORIZED_IP)) {
            return true;
        }
        return false;
        /*------- End Do not touch --------*/
    }
}