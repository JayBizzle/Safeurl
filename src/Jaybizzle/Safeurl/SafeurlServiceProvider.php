<?php namespace Jaybizzle\Safeurl;

use Illuminate\Support\ServiceProvider;

class SafeurlServiceProvider extends ServiceProvider {

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
	public function boot()
	{
		$this->publishes([
			__DIR__.'/../../config/config.php' => base_path('config/safeurl.php')
		]);

		$this->mergeConfigFrom(__DIR__.'/../../config/config.php', 'safeurl');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind('Jaybizzle\Safeurl\Safeurl', function ($app) {
			if ($this->isLumen()) {
				$app->configure('safeurl');
			}
			return new Safeurl();
		});
	}

	private function isLumen()
	{
		return is_a(\app(), 'Laravel\Lumen\Application');
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
