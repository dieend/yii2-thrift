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
class ThriftAction extends \yii\base\InlineAction
{
    /**
     * Arguments for this action
     * @var mixed
     */
    public $actionArguments;
    /**
     * Actual handler for this action.
     * @var ThriftHandlerInterface
     */
    public $handler;

    /**
     * Contruct inline action.
     * @param string           $id              Action id.
     * @param ThriftController $controller      Controller object.
     * @param string           $actionMethod    Method name.
     * @param mixed            $actionArguments Action arguments.
     * @param array            $config          Config.
     */
    public function __construct($id, $controller, $actionMethod, $actionArguments, $config = array())
    {
        $this->actionArguments = $actionArguments;
        $this->handler = $controller;
        parent::__construct($id, $controller, $actionMethod, $config);
    }

    /**
     * Runs this action with the specified parameters.
     * This method is mainly invoked by the controller.
     * @param array $params Action parameters.
     * @return mixed the result of the action
     */
    public function runWithParams($params)
    {
        $params; // unused
        \Yii::trace(
            'Running thrift action with controller '
                . get_class($this->controller) . ': ' . get_class($this->handler)
                . '::' . $this->actionMethod
                . '()',
            __METHOD__
        );
        return call_user_func_array([$this->handler, $this->actionMethod], $this->actionArguments);
    }
}
