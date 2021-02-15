<?php

namespace FOS\PsrHttpBundle\Tests;

use FOS\PsrHttpBundle\Tests\Fixtures\App\Kernel;
use FOS\PsrHttpBundle\Tests\Fixtures\App\Kernel44;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpKernel\Kernel as SymfonyKernel;

/**
 * @author Alexander M. Turek <me@derrabus.de>
 */
final class FOSPsrHttpBundleTest extends WebTestCase
{
    public function testServerRequestAction(): void
    {
        $client = self::createClient();
        $crawler = $client->request('GET', '/server-request');

        self::assertResponseStatusCodeSame(200);
        self::assertSame('GET', $crawler->text());
    }

    public function testRequestAction(): void
    {
        $client = self::createClient();
        $crawler = $client->request('POST', '/request', [], [], [], 'some content');

        self::assertResponseStatusCodeSame(403);
        self::assertSame('POST some content', $crawler->text());
    }

    public function testMessageAction(): void
    {
        $client = self::createClient();
        $crawler = $client->request('PUT', '/message', [], [], ['HTTP_X_MY_HEADER' => 'some content']);

        self::assertResponseStatusCodeSame(422);
        self::assertSame('some content', $crawler->text());
    }

    protected static function getKernelClass(): string
    {
        return SymfonyKernel::VERSION_ID >= 50200 ? Kernel::class : Kernel44::class;
    }
}
