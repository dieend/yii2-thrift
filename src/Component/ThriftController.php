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
abstract class ThriftController extends \yii\base\Controller
{
    /**
     * Get multiplex mapping key with actual handler.
     * @return array
     */
    abstract protected function getHandlerClasses();

    /**
     * [$_thriftProxy description]
     * @var [type]
     */
    private $_thriftProxy;

    /**
     * Initialize component.
     * @return void
     */
    public function init()
    {
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

    /**
     * Execute action.
     * @param  string $id     Action id.
     * @param  array  $params Action parameters.
     * @return mixed
     */
    public function runAction($id, $params = array())
    {
        $id; // unused
        $params; // unused
        return $this->_thriftProxy->run();
    }
}
