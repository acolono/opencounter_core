<?php
/**
 * OpenCounterServiceProvider.
 *
 * a way to inject counter services into the container so they can be used in the app.
 */
namespace OpenCounter\Infrastructure\ServiceProvider;

use League\Container\ServiceProvider\AbstractServiceProvider;
use OpenCounter\Http\CounterBuildService;
use OpenCounter\Infrastructure\Factory\Counter\CounterFactory;
use OpenCounter\Infrastructure\Persistence\Sql\Repository\Counter\SqlCounterRepository;
use OpenCounter\Infrastructure\Persistence\Sql\SqlManager;

/**
 * Class OpenCounterServiceProvider
 * @package OpenCounter\Infrastructure\ServiceProvider
 */
class OpenCounterServiceProvider extends AbstractServiceProvider
{
  /**
   * The provides array is a way to let the container
   * know that a service is provided by this service
   * provider. Every service that is registered via
   * this service provider must have an alias added
   * to this array or it will be ignored.
   *
   * @var array
   */
    protected $provides = [
    'OpenCounter\Infrastructure\Persistence\StorageInterface',
    'OpenCounter\Domain\Repository\CounterRepositoryInterface',
    'counter_build_service'
    ];



  /**
   * This is where the magic happens, within the method you can
   * access the container and register or retrieve anything
   * that you need to, but remember, every alias registered
   * within this method must be declared in the `$provides` array.
   */
    public function register()
    {
        $this->getContainer()->add(
            'OpenCounter\Infrastructure\Persistence\StorageInterface',
            function () {
                $counter_mapper = new SqlManager(
                    $this->getContainer()->get('db')
                );
                return $counter_mapper;
            }
        );


        $this->getContainer()->add(
            'OpenCounter\Domain\Repository\CounterRepositoryInterface',
            function () {
                $counter_mapper = $this->getContainer()
                ->get('OpenCounter\Infrastructure\Persistence\StorageInterface');
                $counter_repository = new SqlCounterRepository(
                    $counter_mapper
                );
                return $counter_repository;
            }
        );

        $this->getContainer()->add(
            'counter_build_service',
            function () {
                $factory = new CounterFactory();

                $counter_build_service = new CounterBuildService(
                    $this->getContainer()->get('counter_repository'),
                    $factory,
                    $this->getContainer()->get('Psr\Log\LoggerInterface')
                );
                return $counter_build_service;
            }
        );
    }
}
