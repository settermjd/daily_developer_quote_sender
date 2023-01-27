<?php

namespace App\InputFilter;

use Laminas\Filter\StringToLower;
use Laminas\Filter\StripNewlines;
use Laminas\Filter\StripTags;
use Laminas\InputFilter\Input;
use Laminas\InputFilter\InputFilter;
use Laminas\Validator\InArray;
use Laminas\Validator\NotEmpty;
use Laminas\Validator\Regex;

class SmsSubscribeUnsubscribeInputFilter extends InputFilter
{
    public function __construct()
    {
        $from = new Input('From');
        $from
            ->getValidatorChain()
            ->attach(new NotEmpty())
            ->attach(new Regex(['pattern' => '/^\+[1-9]\d{1,14}$/']));
        $from
            ->getFilterChain()
            ->attach(new StripNewlines())
            ->attach(new StringToLower())
            ->attach(new StripTags());
        $this->add($from);

        $body = new Input('Body');
        $body
            ->getValidatorChain()
            ->attach(new NotEmpty())
            ->attach(new InArray(
                ['haystack' => ['subscribe', 'unsubscribe']]
            ));
        $body
            ->getFilterChain()
                ->attach(new StripNewlines())
                ->attach(new StringToLower())
                ->attach(new StripTags());
        $this->add($body);
    }
}