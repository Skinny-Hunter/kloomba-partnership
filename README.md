Kloomba/Partnership
===================

## Installation

### Using composer

You can use the composer package manager to install. Either run: 

> composer require kloomba/partnership "@dev"
 
or add: 
> "kloomba/partnership": "@dev"
 
to your composer.json file 

## Usage

> **Attention! For use this package need configure cache component!**

### Variant 1:

```php
<?php
use kloomba\partnership\connectors\CacheConnector;
use kloomba\partnership\components\KloombaApiComponent;
?>
<?= ( new KloombaApiComponent( 'YOUR_PARTNER_KEY', new CacheConnector() ) )->getContent(); ?>
```

### Variant 2 (Widget):

You can use:

```php
<?= \kloomba\partnership\widgets\PartnershipLinksWidget::widget([
    'partnerKey' => 'YOUR_PARTNER_KEY',
]); ?>
```

Automatically will be use KloombaApiComponent:
> \kloomba\partnership\components\KloombaApiComponent

For change it simple add componentClass param to widget:
```php
<?= \kloomba\partnership\widgets\PartnershipLinksWidget::widget([
    'partnerKey' => 'YOUR_PARTNER_KEY',
    'componentClass' => 'CUSTOM_COMPONENT_CLASS',
]); ?>
```

### Variant 3 (for Yii2 >= 2.0.11):
Configure instance of KloombaApiComponent
```php
'container' => [
    'definitions' => [
        'kloombaPartnershipLinksComponent' => [
            [ 'class' => 'kloomba\partnership\components\KloombaApiComponent' ],
            [ 'YOUR_API_KEY' ],
        ],
    ],
]
```
And use it:
```php
<?= \yii\di\Instance::ensure( 'kloombaPartnershipLinksComponent' )->getContent(); ?>
```

## License

**kloomba/partnership** is released under the BSD 3-Clause License. See LICENSE.md for details.
