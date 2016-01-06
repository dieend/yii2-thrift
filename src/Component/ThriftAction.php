<?php

/**
 * Copyright (C) PT. Teknologi Kreasi Anak Bangsa (UrbanIndo.com) - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 */

namespace UrbanIndo\Yii2\Thrift\Component;

/**
 * Description of ThriftAction
 *
 * @author adinata
 */
class ThriftAction extends \yii\base\InlineAction {
    public $actionArguments;
    public $handler;
    
    function __construct($id, $controller, $actionMethod, $actionArguments, $config = array()) {
        $this->actionArguments = $actionArguments;
        $this->handler = $controller;
        parent::__construct($id, $controller, $actionMethod, $config);
    }
    /**
     * Runs this action with the specified parameters.
     * This method is mainly invoked by the controller.
     * @param array $params action parameters
     * @return mixed the result of the action
     */
    public function runWithParams($params)
    {
        \Yii::trace('Running thrift action with controller ' . get_class($this->controller) . ': ' . get_class($this->handler) . '::' . $this->actionMethod . '()', __METHOD__);
        return call_user_func_array([$this->handler, $this->actionMethod], $this->actionArguments);
    }
}
