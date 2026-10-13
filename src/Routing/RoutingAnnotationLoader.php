<?php

declare(strict_types=1);

namespace DH\AuditorBundle\Routing;

use DH\AuditorBundle\Controller\ViewerController;
use RuntimeException;
use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class RoutingAnnotationLoader extends Loader
{
    private bool $isLoaded = false;

    private array $configuration;

    public function __construct(array $configuration)
    {
        $this->configuration = $configuration;
    }

    /**
     * @param mixed       $resource
     * @param null|string $type
     */
    public function load($resource, $type = null): RouteCollection
    {
        if (true === $this->isLoaded) {
            throw new RuntimeException('Do not add the "audit" loader twice');
        }

        $routeCollection = new RouteCollection();
        if (true === $this->configuration['viewer']) {
            $routeCollection->add('dh_auditor_list_audits', new Route('/audit', [
                '_controller' => ViewerController::class.'::listAuditsAction',
            ], [], [], '', [], ['GET']));
            $routeCollection->add('dh_auditor_show_transaction', new Route('/audit/transaction/{hash}', [
                '_controller' => ViewerController::class.'::showTransactionAction',
            ], [], [], '', [], ['GET']));
            $routeCollection->add('dh_auditor_show_entity_history', new Route('/audit/{entity}/{id}', [
                '_controller' => ViewerController::class.'::showEntityHistoryAction',
                'id' => null,
            ], [], [], '', [], ['GET']));
        }

        $this->isLoaded = true;

        return $routeCollection;
    }

    /**
     * @param mixed   $resource
     * @param ?string $type
     */
    public function supports($resource, $type = null): bool
    {
        return 'auditor' === $type;
    }
}
