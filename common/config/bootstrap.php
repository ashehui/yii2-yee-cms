<?php
Yii::setAlias('common', dirname(__DIR__));
Yii::setAlias('frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('console', dirname(dirname(__DIR__)) . '/console');
Yii::setAlias('mapi', dirname(dirname(__DIR__)) . '/mapi');
Yii::setAlias('yeesoft', dirname(dirname(__DIR__)) . '/vendor/yeesoft');
Yii::setAlias('root', $_SERVER['DOCUMENT_ROOT']);