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
        return (in_array($this->ipService->get(), self::AUTHORIZED_IP) ? true : false);
        /*------- End Do not touch --------*/
    }
}