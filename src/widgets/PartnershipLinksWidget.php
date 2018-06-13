<?php
/**
 * PartnershipLinksWidget
 *
 * @author  Skinny Hunter <skinny.hunter@gmail.com>
 * @version 1.0.0
 */

namespace kloomba\partnership\widgets;

use kloomba\partnership\components\KloombaApiComponent;
use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\di\Instance;
use Yii;

/**
 * Class PartnershipLinksWidget
 */
class PartnershipLinksWidget extends Widget
{

	/**
	 * @var string
	 */
	public $partnerKey;

	/**
	 * @var string
	 */
	public $componentClass = 'kloomba\partnership\components\KloombaApiComponent';

	/**
	 * @var string
	 */
	public $componentName;

	/**
	 * @var KloombaApiComponent
	 */
	protected $component;

	/**
	 * Widget initialize
	 */
	public function init()
	{
		if( $this->partnerKey && $this->componentClass ) {
			$this->component = Yii::createObject(
				$this->componentClass,
				[ $this->partnerKey ]
			);
		} else if( $this->componentName ) {
			$this->component = Instance::ensure( $this->componentName );
		} else {
			throw new InvalidConfigException( 'You need configure component name or component class and partner key' );
		}
	}

	/**
	 * Widget run
	 */
	public function run()
	{
		return $this->component->getContent();
	}

}
