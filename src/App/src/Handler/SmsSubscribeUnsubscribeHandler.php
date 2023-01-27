<?php

declare(strict_types=1);

namespace App\Handler;

use Laminas\Diactoros\Response\XmlResponse;
use Laminas\InputFilter\InputFilterInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Twilio\TwiML\MessagingResponse;

class SmsSubscribeUnsubscribeHandler implements RequestHandlerInterface
{
    const MESSAGE_SUBSCRIBE_SUCCESS = <<<EOF
You are now subscribed to the daily developer quotes service. 
To unsubscribe, send another SMS to this number with the text: UNSUBSCRIBE
EOF;

    const MESSAGE_UNSUBSCRIBE_SUCCESS = <<<EOF
You are now unsubscribed from the daily developer quotes service. 
You will no longer receive the daily developer quotes.
EOF;

    const MESSAGE_FAILURE = <<<EOF
To subscribe to the daily developer quotes service, text SUBSCRIBE. 
To unsubscribe, text UNSUBSCRIBE.
EOF;

    private InputFilterInterface $inputFilter;
    private MessagingResponse $response;

    public function __construct(InputFilterInterface $inputFilter)
    {
        $this->inputFilter = $inputFilter;
        $this->response = new MessagingResponse();
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $requestData = $request->getParsedBody();

        $this->inputFilter->setData($requestData);
        match ($this->inputFilter->isValid($requestData)) {
            true => $this->response->message(
                $this->getTwimlResponse(
                    $this->inputFilter->getValue('Body')
                )
            ),
            false => $this->response->message(self::MESSAGE_FAILURE),
        };

        return new XmlResponse($this->response->asXML());
    }

    /**
     * Builds the string to return to Twilio in the TwiML response
     */
    private function getTwimlResponse(string $subscribeUnsubscribe): string
    {
        match ($subscribeUnsubscribe) {
            'subscribe' => $message = self::MESSAGE_SUBSCRIBE_SUCCESS,
            'unsubscribe' => $message = self::MESSAGE_UNSUBSCRIBE_SUCCESS,
        };

        return $message;
    }
}
