<?php
/**
 * Copyright (C) PT. Teknologi Kreasi Anak Bangsa (UrbanIndo.com) - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 */

namespace UrbanIndo\Yii2\Thrift\Component;

use ReflectionMethod;
use Thrift\Exception\TException;
use Yii;
use yii\base\Action;
use yii\base\Component;
use yii\gii\Module;
use yii\web\NotFoundHttpException;

/**
 * Description of ThriftProxy
 *
 * @author adinata
 */
class ThriftProxy extends Component
{
    /**
     *
     * @var ThriftHandlerInterface Actual handler for service.
     */
    public $handler;

    /**
     * Magic method that will forward action being called from Thrift processor
     * @param string $methodName Service method name.
     * @param mixed  $arguments  Arguments.
     * @return mixed
     * @throws NotFoundHttpException When method not found.
     */
    public function __call($methodName, $arguments)
    {
        try {
            $action = $this->createAction($methodName, $arguments);
            if ($action == null) {
                throw new NotFoundHttpException("Can't found method " . $methodName);
            }
            return $this->runAction($action);
        } catch (\Exception $e) {
            \Yii::error($e->getMessage() . "\n" . $e->getTraceAsString(), 'ThriftError');
            if ($e instanceof TException) {
                throw $e;
            } else {
                $this->handler->handleException($e);
            }
        }
    }
    
    /**
     * Cloned from \yii\base\Controller::runAction.
     * It was because runAction use $id and $route as parameter instead of action object
     * @param ThriftAction $action Action object being called.
     * @return mixed
     */
    protected function runAction(ThriftAction $action)
    {
        Yii::trace('Route to run: ' . $action->getUniqueId(), __METHOD__);
        $controller = $this->handler;

        if (Yii::$app->requestedAction === null) {
            Yii::$app->requestedAction = $action;
        }

        $oldAction = $controller->action ;
        $controller->action = $action;
        
        $modules = [];
        $runAction = true;
        
        // call beforeAction on modules
        foreach ($controller->getModules() as $module) {
            if ($module->beforeAction($action)) {
                array_unshift($modules, $module);
            } else {
                $runAction = false;
                break;
            }
        }

        $result = null;

        if ($runAction && $controller->beforeAction($action)) {
            // run the action
            $result = $action->runWithParams([]);
            $result = $controller->afterAction($action, $result);
            
            // call afterAction on modules
            foreach ($modules as $module) {
                /* @var $module Module */
                $result = $module->afterAction($action, $result);
            }
        }

        $controller->action = $oldAction;

        return $result;
    }
    
    /**
     * Wrap service into InlineAction.
     * @param string $methodName Service method name.
     * @param mixed  $arguments  Arguments.
     * @return ThriftAction
     */
    private function createAction($methodName, $arguments)
    {
        $controller = $this->handler;

        if (method_exists($controller, $methodName)) {
            $method = new ReflectionMethod($controller, $methodName);
            if ($method->isPublic() && $method->getName() === $methodName) {
                return new ThriftAction($methodName, $controller, $methodName, $arguments);
            }
        }
        return null;
    }
}
