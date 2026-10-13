<?php

declare(strict_types=1);

namespace DH\AuditorBundle\Tests;

use DH\Auditor\Auditor;
use DH\Auditor\Configuration as AuditorConfiguration;
use DH\Auditor\Provider\Doctrine\Configuration as DoctrineProviderConfiguration;
use DH\Auditor\Provider\Doctrine\DoctrineProvider;
use DH\Auditor\Provider\Doctrine\Persistence\Event\CreateSchemaListener;
use DH\Auditor\Provider\Doctrine\Persistence\Reader\Reader;
use DH\AuditorBundle\Controller\ViewerController;
use DH\AuditorBundle\Event\ConsoleEventSubscriber;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * @internal
 *
 * @small
 */
final class DHAuditorBundleTest extends KernelTestCase
{
    public function testInitBundle(): void
    {
        self::bootKernel();
        $container = method_exists(self::class, 'getContainer') ? self::getContainer() : self::$container;

        self::assertTrue($container->has(AuditorConfiguration::class));
        self::assertInstanceOf(AuditorConfiguration::class, $container->get(AuditorConfiguration::class));

        self::assertTrue($container->has(Auditor::class));
        self::assertInstanceOf(Auditor::class, $container->get(Auditor::class));

        self::assertTrue($container->has(DoctrineProviderConfiguration::class));
        self::assertInstanceOf(DoctrineProviderConfiguration::class, $container->get(DoctrineProviderConfiguration::class));

        self::assertTrue($container->has(DoctrineProvider::class));
        self::assertInstanceOf(DoctrineProvider::class, $container->get(DoctrineProvider::class));

        self::assertTrue($container->has('dh_auditor.provider.doctrine'));
        self::assertInstanceOf(DoctrineProvider::class, $container->get('dh_auditor.provider.doctrine'));

        self::assertTrue($container->has(Reader::class));
        self::assertInstanceOf(Reader::class, $container->get(Reader::class));

        self::assertTrue($container->has(CreateSchemaListener::class));
        self::assertInstanceOf(CreateSchemaListener::class, $container->get(CreateSchemaListener::class));

        self::assertTrue($container->has(ViewerController::class));
        self::assertInstanceOf(ViewerController::class, $container->get(ViewerController::class));

        self::assertTrue($container->has(ConsoleEventSubscriber::class));
        self::assertInstanceOf(ConsoleEventSubscriber::class, $container->get(ConsoleEventSubscriber::class));
    }
}
