<?php

namespace FOS\PsrHttpBundle\ArgumentValueResolver;

use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Bridge\PsrHttpMessage\HttpMessageFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

/**
 * Injects the RequestInterface, MessageInterface or ServerRequestInterface when requested.
 *
 * @author Iltar van der Berg <kjarli@gmail.com>
 */
final class Psr7ServerRequestResolver implements ArgumentValueResolverInterface
{
    private const SUPPORTED_TYPES = [
        ServerRequestInterface::class => true,
        RequestInterface::class => true,
        MessageInterface::class => true,
    ];

    private $httpMessageFactory;

    public function __construct(HttpMessageFactoryInterface $httpMessageFactory)
    {
        $this->httpMessageFactory = $httpMessageFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        return isset(self::SUPPORTED_TYPES[$argument->getType()]);
    }

    /**
     * {@inheritdoc}
     */
    public function resolve(Request $request, ArgumentMetadata $argument): \Traversable
    {
        yield $this->httpMessageFactory->createRequest($request);
    }
}
