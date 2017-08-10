<?php
$_db = require_once Yii::getAlias('@root').'/common/config/db.php';
$_db['tablePrefix'] = 'cms_';
return $_db;