<?php

namespace FOS\PsrHttpBundle\Tests\Fixtures\App;

use FOS\PsrHttpBundle\FOSPsrHttpBundle;
use FOS\PsrHttpBundle\Tests\Fixtures\App\Controller\PsrRequestController;
use Psr\Log\NullLogger;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel as SymfonyKernel;
use Symfony\Component\Routing\RouteCollectionBuilder;

class Kernel44 extends SymfonyKernel
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

    protected function configureRoutes(RouteCollectionBuilder $routes): void
    {
        $routes
            ->add('/server-request', PsrRequestController::class.'::serverRequestAction')
            ->setMethods(['GET'])
        ;

        $routes
            ->add('/request', PsrRequestController::class.'::requestAction')
            ->setMethods(['POST'])
        ;

        $routes
            ->add('/message', PsrRequestController::class.'::messageAction')
            ->setMethods(['PUT'])
        ;
    }

    protected function configureContainer(ContainerBuilder $container, LoaderInterface $loader): void
    {
        $container->loadFromExtension('framework', [
            'test' => true,
        ]);
        $container->loadFromExtension('fos_psr_http', []);

        $container->register('logger', NullLogger::class);
        $container->register(PsrRequestController::class)->setPublic(true)->setAutowired(true);
    }
}
