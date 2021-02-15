<?php

namespace FOS\PsrHttpBundle\Tests\Fixtures\App;

use FOS\PsrHttpBundle\FOSPsrHttpBundle;
use FOS\PsrHttpBundle\Tests\Fixtures\App\Controller\PsrRequestController;
use Psr\Log\NullLogger;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Kernel as SymfonyKernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

class Kernel extends SymfonyKernel
{
    use MicroKernelTrait;

    public function registerBundles(): iterable
    {
        yield new FrameworkBundle();
        yield new FOSPsrHttpBundle();
    }

    public function getProjectDir(): string
    {
        return __DIR__;
    }

    protected function configureRoutes(RoutingConfigurator $routes): void
    {
        $routes
            ->add('server_request', '/server-request')->controller([PsrRequestController::class, 'serverRequestAction'])->methods(['GET'])
            ->add('request', '/request')->controller([PsrRequestController::class, 'requestAction'])->methods(['POST'])
            ->add('message', '/message')->controller([PsrRequestController::class, 'messageAction'])->methods(['PUT'])
        ;
    }

    protected function configureContainer(ContainerConfigurator $container): void
    {
        $container->extension('framework', [
            'router' => ['utf8' => true],
            'test' => true,
        ]);
        $container->extension('fos_psr_http', []);

        $container->services()
            ->set('logger', NullLogger::class)
            ->set(PsrRequestController::class)->public()->autowire()
        ;
    }
}
