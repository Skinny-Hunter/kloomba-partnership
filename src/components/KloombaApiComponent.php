<?php declare( strict_types = 1 );
/**
 * KloombaApiComponent
 *
 * @author  Skinny Hunter <skinny.hunter@gmail.com>
 * @version 1.0.0
 */

namespace kloomba\partnership\components;

use kloomba\partnership\connectors\CacheConnector;

/**
 * Class KloombaApiComponent
 */
class KloombaApiComponent
{

	const API_VERSION = '1.0.0';

	const ERROR_API_CONNECTION = 3;
	const ERROR_API_RESPONSE = 4;

	/**
	 * @var string
	 */
	public $partnerKey;

	/**
	 * @var string
	 */
	protected $cacheKey = 'KloombaPartnershipLinksApi.cache';

	/**
	 * @var string
	 */
	protected $apiUrlTemplate = 'https://kloomba.com/ad/partner/%s/?v=%s';

	/**
	 * @var int
	 */
	protected $apiRequestTimeout = 2;

	/**
	 * KloombaApiComponent constructor
	 *
	 * @param string $partnerKey
	 */
	public function __construct( $partnerKey, CacheConnector $cache )
	{
		$this->partnerKey = $partnerKey;
		$this->cache = $cache;
	}

	/**
	 * Returns component template
	 *
	 * @return bool|mixed|string
	 */
	public function getContent()
	{
		if( $content = $this->cache->get( $this->cacheKey ) ) {
			return $content;
		}

		$url = sprintf( $this->apiUrlTemplate, $this->partnerKey, static::API_VERSION );

		$options = [
			'http' => [
				'timeout' => $this->apiRequestTimeout
			]
		];
		$context = stream_context_create( $options );

		$content = @file_get_contents( $url, null, $context );
		$headers = $this->parseHeaders( $http_response_header );

		if( $headers['Response-Code'] == 200 && $content !== false ) {
			$this->cache->set( $this->cacheKey, $content );
		} else {
			$content = $this->getErrorContent( $headers['Response-Code'] );
		}

		return $content;
	}

	/**
	 * Converts headers list to key => value pairs array
	 *
	 * @param array $headers
	 *
	 * @return mixed
	 */
	protected function parseHeaders( array $headers )
	{
		return array_reduce( $headers, function( $list, $header ) {
			$args = explode( ':', $header, 2 );
			if( isset( $args[1] ) ) {
				$list[ $args[0] ] = $args[1];
			} else if( preg_match( '#HTTP/[0-9\.]+\s+([0-9]+)#', $args[0], $match ) ) {
				$list['Response-Code'] = intval( $match[1] );
			}
			return $list;
		}, [] );
	}

	/**
	 * Returns error content by code
	 *
	 * @param $code
	 *
	 * @return string
	 */
	protected function getErrorContent( $code )
	{
		$template = '<span class="kl-kloomba-partnership-links-error" style="display: none" data-error="%s">%s</span>';
		return sprintf( $template, $code, $code );
	}

}
