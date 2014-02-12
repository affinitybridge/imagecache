<?php namespace Affinity\Imagecache;

use Illuminate\Support\ServiceProvider;

class ImagecacheServiceProvider extends ServiceProvider {

  /**
   * Bootstrap the application events.
   *
   * @return void
   */
  public function boot() {
  }

  /**
   * Register the service provider.
   *
   * @return void
   */
  public function register() {
    $this->package('affinity/imagecache');

    $this->app->singleton('imagecache', function ($app) {
      $public_dir = \public_path();
      $cache_root_dir = $this->app['config']->get('imagecache::cache_root_dir', "$public_dir/uploads");
      $cache_web_dir = $this->app['config']->get('imagecache::cache_web_dir', "/uploads");
      $default_placeholder = $this->app['config']->get('imagecache::default_placeholder');
      $presets = $this->app['config']->get('imagecache::presets', array());
      return new Imagecache($cache_root_dir, $cache_web_dir, $presets, $default_placeholder);
    });
  }

  /**
   * Get the services provided by the provider.
   *
   * @return array
   */
  public function provides() {
    return array();
  }

}
