<?php namespace Jaybizzle\Safeurl\Facades;

use Illuminate\Support\Facades\Facade;

class Safeurl extends Facade {
  /**
   * Get the registered name of the component.
   *
   * Don't use this. Just... don't.
   *
   * @return string
   */
  protected static function getFacadeAccessor()
  {
      return 'Jaybizzle\Safeurl\Safeurl';
  }

}
