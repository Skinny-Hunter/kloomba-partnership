<?php declare( strict_types = 1 );
/**
 * CacheConnector
 *
 * @author  Skinny Hunter <skinny.hunter@gmail.com>
 * @version 1.0.0
 */

namespace kloomba\partnership\connectors;

use Yii;
use yii\base\InvalidConfigException;

/**
 * Class CacheConnector
 */
class CacheConnector
{

	/**
	 * @var \yii\caching\Cache
	 */
	protected $cache;

	/**
	 * CacheConnector constructor
	 *
	 * @throws InvalidConfigException
	 */
	public function __construct()
	{
		$this->cache = Yii::$app->getCache();
		if( empty( $this->cache ) ) {
			throw new InvalidConfigException( 'Cache component must be configured' );
		}
	}

	/**
	 * Returns cache value
	 *
	 * @param string $key
	 *
	 * @return mixed
	 */
	public function get( $key )
	{
		return $this->cache->get( $key );
	}

	/**
	 * Sets value to cache
	 *
	 * @param string $key
	 * @param        $value
	 */
	public function set( $key, $value )
	{
		$this->cache->set( $key, $value );
	}

	/**
	 * Checks property in cache
	 *
	 * @param string $key
	 *
	 * @return bool
	 */
	public function exists( $key )
	{
		return $this->cache->exists( $key );
	}

	/**
	 * Remove property from cache
	 *
	 * @param string $key
	 */
	public function delete( $key )
	{
		$this->cache->delete( $key );
	}

}
