<?php

namespace AppTest\Handler;

use App\Handler\SmsSubscribeUnsubscribeHandler;
use App\InputFilter\SmsSubscribeUnsubscribeInputFilter;
use Laminas\Diactoros\Response\XmlResponse;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;

class SmsSubscribeUnsubscribeHandlerTest extends TestCase
{
    public function testCanHandleSubscribeRequest(): void
    {
        $inputFilter = new SmsSubscribeUnsubscribeInputFilter();
        $homePage = new SmsSubscribeUnsubscribeHandler($inputFilter);

        $serverRequest = $this->createMock(ServerRequestInterface::class);
        $serverRequest
            ->expects($this->once())
            ->method('getParsedBody')
            ->willReturn([
                'From' => '+16175551212',
                'Body' => 'Subscribe'
            ]);
        $response = $homePage->handle($serverRequest);

        $twiml = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<Response><Message>You are now subscribed to the daily developer quotes service. 
To unsubscribe, send another SMS to this number with the text: UNSUBSCRIBE</Message></Response>

EOF;

        self::assertInstanceOf(XmlResponse::class, $response);
        self::assertSame($twiml, $response->getBody()->getContents());
    }

    public function testCanHandleUnsubscribeRequest(): void
    {
        $inputFilter = new SmsSubscribeUnsubscribeInputFilter();
        $homePage = new SmsSubscribeUnsubscribeHandler($inputFilter);

        $serverRequest = $this->createMock(ServerRequestInterface::class);
        $serverRequest
            ->expects($this->once())
            ->method('getParsedBody')
            ->willReturn([
                'From' => '+16175551212',
                'Body' => 'Unsubscribe'
            ]);
        $response = $homePage->handle($serverRequest);

        $twiml = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<Response><Message>You are now unsubscribed from the daily developer quotes service. 
You will no longer receive the daily developer quotes.</Message></Response>

EOF;

        self::assertInstanceOf(XmlResponse::class, $response);
        self::assertSame($twiml, $response->getBody()->getContents());
    }

    /**
     * @dataProvider invalidRequestProvider
     */
    public function testCanHandleInvalidRequest(string $body): void
    {
        $inputFilter = new SmsSubscribeUnsubscribeInputFilter();
        $homePage = new SmsSubscribeUnsubscribeHandler($inputFilter);

        $serverRequest = $this->createMock(ServerRequestInterface::class);
        $serverRequest
            ->expects($this->once())
            ->method('getParsedBody')
            ->willReturn([
                'From' => '+16175551212',
                'Body' => $body
            ]);
        $response = $homePage->handle($serverRequest);

        $twiml = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<Response><Message>To subscribe to the daily developer quotes service, text SUBSCRIBE. 
To unsubscribe, text UNSUBSCRIBE.</Message></Response>

EOF;

        self::assertInstanceOf(XmlResponse::class, $response);
        self::assertSame($twiml, $response->getBody()->getContents());
    }

    /**
     * @return array<int,string>
     */
    public function invalidRequestProvider(): array
    {
        return [
            [
                'sabscribe'
            ],
            [
                'unSabscr1b3'
            ]
        ];
    }

}
