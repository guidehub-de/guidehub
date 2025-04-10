<?php

declare(strict_types=1);

namespace App\Tests\ApiTests;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Message\SendEmailMessage;
use Symfony\Component\Mime\RawMessage;
use Zenstruck\Messenger\Test\InteractsWithMessenger;

class SendMailTest extends ApiTestCase
{
    use InteractsWithMessenger;

    public function testSendMail(): void
    {
        $client = self::createClient();

        $client->request('GET', '/mail/send');

        $this->transport()->queue()->assertCount(1);
        $this->transport()->queue()->assertContains(SendEmailMessage::class);
        $this->transport()->processOrFail();

        self::assertEmailCount(1);

        /** @var RawMessage $email */
        $email = self::getMailerMessage();

        self::assertEmailSubjectContains(
            $email,
            'Test-Mail',
        );
        self::assertEmailHtmlBodyContains(
            $email,
            'Hello world!',
        );
    }
}
