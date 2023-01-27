<?php

namespace AppTest\Handler;

use App\Handler\SmsSubscribeUnsubscribeHandlerFactory;
use App\Handler\SmsSubscribeUnsubscribeHandler;
use Laminas\InputFilter\InputFilterInterface;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

class SmsSubscribeUnsubscribeHandlerFactoryTest extends TestCase
{
    protected function setUp(): void
    {
        $this->container = $this->createMock(ContainerInterface::class);
    }

    public function testCanInstantiateHandler(): void
    {
        $this->container
            ->expects($this->once())
            ->method('get')
            ->with(InputFilterInterface::class)
            ->willReturn($this->createMock(InputFilterInterface::class));

        $factory = new SmsSubscribeUnsubscribeHandlerFactory();
        $handler = $factory($this->container);

        self::assertInstanceOf(SmsSubscribeUnsubscribeHandler::class, $handler);
    }
}
