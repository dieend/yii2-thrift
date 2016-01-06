<?php

/**
 * Copyright (C) PT. Teknologi Kreasi Anak Bangsa (UrbanIndo.com) - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 */

namespace UrbanIndo\Yii2\Thrift\Component;

/**
 * Description of ThriftController
 *
 * @author adinata
 */

abstract class ThriftController extends \yii\base\Controller {
    protected abstract function getHandlerClasses();
    private $_thriftProxy;
    
    public function init() {
        parent::init();
        $handlers = [];
        foreach ($this->getHandlerClasses() as $name => $class) {
            $handlers[] = \Yii::createObject(['class' => $class], [$name, $this]);
        }
        
        $this->_thriftProxy = \Yii::createObject(
            [
                'class' => \common\components\thrift\ThriftProcessor::class,
                'handlers' => $handlers,
            ]
        );
    }

    public function runAction($id, $params = array()) {
        return $this->_thriftProxy->run();
    }
}
