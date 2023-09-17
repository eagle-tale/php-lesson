<?php

include_once('..\repositories\UserRepository.php');
include_once('..\repositories\InMemoryUserRepository.php');
include_once('..\services\UserService.php');

class ApplicationServiceFactory
{
    static function createApplicationService($environment = 'production')
    {
        $service = null;
        switch ($environment) {
            case 'production':
                $userRepository = new UserRepository();
                $userService = new UserService($userRepository);
                $service = new ApplicationService($userRepository, $userService);
                break;
            case 'development':
                $userRepository = new InMemoryUserRepository();
                $userService = new UserService($userRepository);
                $service = new ApplicationService($userRepository, $userService);
                break;
            default:
                throw new Exception('environmentの値が不正です');
        }

        return $service;
    }
}
