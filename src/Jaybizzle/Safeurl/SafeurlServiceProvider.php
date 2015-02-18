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
		$this->registerConfig();
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['safeurl'] = $this->app->share(function($app)
		{
			return new Safeurl;
		});
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

	/**
	 * Register our config file
	 *
	 * @return void
	 */
	protected function registerConfig()
	{
		// The path to the user config file
		$userConfigPath    = app()->configPath() . '/packages/jaybizzle/safeurl/config.php';

		// Path to the default config
		$defaultConfigPath = __DIR__ . '/../../config/config.php';

		// Load the default config
		$config = $this->app['files']->getRequire($defaultConfigPath);

		if (file_exists($userConfigPath)) 
		{       
			// User has their own config, let's merge them properly
			$userConfig = $this->app['files']->getRequire($userConfigPath);
			$config     = array_replace_recursive($config, $userConfig);
		}

		// Set each of the items like ->package() previously did
		$this->app['config']->set('safeurl::config', $config);
	}

}
