Yii2-we-work
============
Yii2 wechat work SDK

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist dovechen/yii2-we-work "*"
```

or add

```
"dovechen/yii2-we-work": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
/** @var Work $workApi */
$workApi = \Yii::createObject([
    'class'  => Work::className(),
    'corpid' => $corpid,
    'secret' => $secret,
]);

/** @var Work $agentApi */
$agentApi = \Yii::createObject([
    'class'  => Work::className(),
    'corpid' => $corpid,
    'secret' => $agentSecret,
]);

/** @var ServiceWork $serviceWork */
$serviceWork = \Yii::createObject([
    'class'          => ServiceWork::className(),
    'suite_id'       => $suiteId,
    'suite_secret'   => $suiteSecret,
    'suite_ticket'   => $suiteTicket,
    'auth_corpid'    => $authCorpid,
    'permanent_code' => $permanentCode,
]);

/** @var ServiceProvider $serviceProvider */
$serviceProvider = \Yii::createObject([
    'class'           => ServiceProvider::className(),
    'provider_corpid' => $providerCorpid,
    'provider_secret' => $providerSecret,
]);
```