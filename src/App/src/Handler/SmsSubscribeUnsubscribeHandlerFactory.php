<?php

declare(strict_types=1);

namespace App\Handler;

use Laminas\InputFilter\InputFilterInterface;
use Psr\Container\ContainerInterface;

class SmsSubscribeUnsubscribeHandlerFactory
{
    public function __invoke(ContainerInterface $container) : SmsSubscribeUnsubscribeHandler
    {
        return new SmsSubscribeUnsubscribeHandler($container->get(InputFilterInterface::class));
    }
}
