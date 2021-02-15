<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use FOS\PsrHttpBundle\ArgumentValueResolver\Psr7ServerRequestResolver;
use FOS\PsrHttpBundle\EventListener\PsrResponseListener;
use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UploadedFileFactoryInterface;
use Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory;
use Symfony\Bridge\PsrHttpMessage\Factory\PsrHttpFactory;
use Symfony\Bridge\PsrHttpMessage\HttpFoundationFactoryInterface;
use Symfony\Bridge\PsrHttpMessage\HttpMessageFactoryInterface;
use Symfony\Component\DependencyInjection\Reference;

return static function (ContainerConfigurator $container): void {
    $container->services()
        ->set('psr_http.http_message_factory', PsrHttpFactory::class)
            ->args([
                new Reference('psr_http.nyholm.psr17_factory'),
                new Reference('psr_http.nyholm.psr17_factory'),
                new Reference('psr_http.nyholm.psr17_factory'),
                new Reference('psr_http.nyholm.psr17_factory'),
            ])
        ->alias(HttpMessageFactoryInterface::class, 'psr_http.http_message_factory')

        ->set('psr_http.http_foundation_factory', HttpFoundationFactory::class)
        ->alias(HttpFoundationFactoryInterface::class, 'psr_http.http_foundation_factory')

        ->set('psr_http.nyholm.psr17_factory', Psr17Factory::class)
        ->alias(ServerRequestFactoryInterface::class, 'psr_http.nyholm.psr17_factory')
        ->alias(UploadedFileFactoryInterface::class, 'psr_http.nyholm.psr17_factory')
        ->alias(ResponseFactoryInterface::class, 'psr_http.nyholm.psr17_factory')
        ->alias(StreamFactoryInterface::class, 'psr_http.nyholm.psr17_factory')

        ->set('psr_http.psr_response_listener', PsrResponseListener::class)
            ->args([
                new Reference('psr_http.http_foundation_factory'),
            ])
            ->tag('kernel.event_subscriber')

        ->set('psr_http.server_request_argument_value_resolver', Psr7ServerRequestResolver::class)
            ->args([
                new Reference('psr_http.http_message_factory'),
            ])
            ->tag('controller.argument_value_resolver')
    ;
};
