<?php namespace Vittee\DebugbarDoctrine;

use Illuminate\Support\ServiceProvider;
use DebugBar\DataCollector\PDO\TraceablePDO;
use DebugBar\DataCollector\PDO\PDOCollector;
use Vittee\DebugbarDoctrine\DataCollector\Doctrine\PDODoctrineCollector;

class DebugbarDoctrineServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot() {
    	if ($this->app['config']->get('laravel-debugbar::config.enabled')) {

    		$debugbar = $this->app['debugbar'];

    		if ($debugbar && $this->app['config']->get('laravel-debugbar::config.enabled')) {
				
				if ($this->collects('db', true) and isset($this->app['db'])) { 
					try {
						$doctrine = $this->app['doctrine'];

						if ($doctrine) {
							$pdo = $doctrine->getConnection()->getWrappedConnection();
							
							foreach ($debugbar->getCollectors() as $collector) {
								if ($collector instanceof PDOCollector) {
									$collector->addConnection(new TraceablePDO($pdo));
									break;
								}
							}
						}

					} catch (\PDOException $e) {

					}
				}
			}
		}
    }

    public function collects($name, $default=false){
        return $this->app['config']->get('laravel-debugbar::config.collectors.'.$name, $default);
    }

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register() {
		$this->package('vittee/debugbar-doctrine');		
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}



}