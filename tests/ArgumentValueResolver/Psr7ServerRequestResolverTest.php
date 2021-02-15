<?php

namespace FOS\PsrHttpBundle\Tests\ArgumentValueResolver;

use FOS\PsrHttpBundle\ArgumentValueResolver\Psr7ServerRequestResolver;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Bridge\PsrHttpMessage\HttpMessageFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;

/**
 * @author Alexander M. Turek <me@derrabus.de>
 */
final class Psr7ServerRequestResolverTest extends TestCase
{
    public function testServerRequest(): void
    {
        $symfonyRequest = $this->createMock(Request::class);
        $psrRequest = $this->createMock(ServerRequestInterface::class);

        $resolver = $this->bootstrapResolver($symfonyRequest, $psrRequest);

        self::assertSame([$psrRequest], $resolver->getArguments($symfonyRequest, static function (ServerRequestInterface $serverRequest): void {}));
    }

    public function testRequest(): void
    {
        $symfonyRequest = $this->createMock(Request::class);
        $psrRequest = $this->createMock(ServerRequestInterface::class);

        $resolver = $this->bootstrapResolver($symfonyRequest, $psrRequest);

        self::assertSame([$psrRequest], $resolver->getArguments($symfonyRequest, static function (RequestInterface $request): void {}));
    }

    public function testMessage(): void
    {
        $symfonyRequest = $this->createMock(Request::class);
        $psrRequest = $this->createMock(ServerRequestInterface::class);

        $resolver = $this->bootstrapResolver($symfonyRequest, $psrRequest);

        self::assertSame([$psrRequest], $resolver->getArguments($symfonyRequest, static function (MessageInterface $request): void {}));
    }

    private function bootstrapResolver(Request $symfonyRequest, ServerRequestInterface $psrRequest): ArgumentResolver
    {
        $messageFactory = $this->createMock(HttpMessageFactoryInterface::class);
        $messageFactory->expects(self::once())
            ->method('createRequest')
            ->with(self::identicalTo($symfonyRequest))
            ->willReturn($psrRequest);

        return new ArgumentResolver(null, [new Psr7ServerRequestResolver($messageFactory)]);
    }
}
