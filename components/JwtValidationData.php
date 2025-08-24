<?php

namespace app\components;

use sizeg\jwt\JwtValidationData as BaseJwtValidationData;

class JwtValidationData extends BaseJwtValidationData
{
    public function init()
    {
        $this->validationData->setIssuer('http://localhost');
        $this->validationData->setAudience('http://localhost');
        $this->validationData->setId('yii2-request-api-local');

        parent::init();
    }
}