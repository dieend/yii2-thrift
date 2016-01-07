<?php
/**
 * Copyright (C) PT. Teknologi Kreasi Anak Bangsa (UrbanIndo.com) - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 */

namespace UrbanIndo\Yii2\Thrift\Component;

/**
 * Description of ThriftProcessor
 *
 * @author adinata
 */
class ThriftProcessor extends \yii\base\Component
{
    /**
     * Handlers for this processor.
     * @var array
     */
    public $handlers = [];

    /**
     * Processor
     * @var \Thrift\TMultiplexedProcessor
     */
    private $_processor;

    /**
     * Initialize component
     * @return void
     */
    public function init()
    {
        $this->_processor = new \Thrift\TMultiplexedProcessor();
        /* @var $handler ThriftProcessorHandler */
        foreach ($this->handlers as $handler) {
            $proxy = \Yii::createObject([
               'class' => ThriftProxy::class,
               'handler' => $handler,
            ]);
            $processorClass = $handler->getProcessorClass();
            $processor = new $processorClass($proxy);
            $this->_processor->registerProcessor(
                $handler->getProcessorName(),
                $processor
            );
        }
    }

    /**
     * Run processor.
     * @return [type] [description]
     */
    public function run()
    {
        $request = \Yii::$app->getRequest();
        $response = \Yii::$app->getResponse();
        $response->format = ThriftResponse::FORMAT_THRIFT;
        $transport = new \Thrift\Transport\TMemoryBuffer($request->getRawBody());
        $protocol = new \Thrift\Protocol\TBinaryProtocol($transport, true, true);
        $this->_processor->process($protocol, $protocol);
        return $transport->getBuffer();
    }
}
