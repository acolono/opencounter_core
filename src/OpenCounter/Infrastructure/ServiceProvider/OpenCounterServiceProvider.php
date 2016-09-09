<?php
namespace OpenCounter\Infrastructure\ServiceProvider;

use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Container\ServiceProvider\BootableServiceProviderInterface;

class OpenCounterServiceProvider extends AbstractServiceProvider implements BootableServiceProviderInterface
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
        'counter_mapper',
        'counter_repository',
        'counter_build_service'
    ];

    public function boot()
    {
        $this->getContainer();
//          ->inflector('SomeType')
//          ->invokeMethod('someMethod', ['some_arg']);

    }

    /**
     * This is where the magic happens, within the method you can
     * access the container and register or retrieve anything
     * that you need to, but remember, every alias registered
     * within this method must be declared in the `$provides` array.
     */
    public function register()
    {
        $this->getContainer()->share('counter_mapper', function () {
            $counter_mapper = new \OpenCounter\Infrastructure\Persistence\Sql\SqlManager($this->getContainer()->get('db'));
            return $counter_mapper;
        });


        $this->getContainer()->share('counter_repository', function () {
            $counter_mapper = $this->getContainer()->get('counter_mapper');
            $counter_repository = new \OpenCounter\Infrastructure\Persistence\Sql\Repository\Counter\SqlPersistentCounterRepository($counter_mapper);
            return $counter_repository;
        });

        $this->getContainer()->share('counter_build_service', function () {
            $factory = new \OpenCounter\Infrastructure\Factory\Counter\CounterFactory();

            $counter_build_service = new \OpenCounter\Http\CounterBuildService($this->getContainer()->get('counter_repository'), $factory, $this->getContainer()['logger']);
            return $counter_build_service;
        });
    }
}