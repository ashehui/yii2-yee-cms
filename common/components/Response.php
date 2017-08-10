<?php
namespace common\components;

class Response extends \yii\web\Response
{
    public $errno = 0;

    public $errmsg = '';




    public function getSchema()
    {
        return \Yii::$app->params['schema']['response'];
    }

    public function getSchemaData()
    {
        $controllerId = \Yii::$app->controller->id;
        $actionId = \Yii::$app->controller->module->requestedAction->id;

        $schemaId = "{$controllerId}_{$actionId}";
        $schema = $this->getSchema();

        if (!empty($schema[$schemaId])) {
            return array_intersect($this->data, array_flip($schema[$schemaId]));
        } else {
            return $this->data;
        }

    }












}

