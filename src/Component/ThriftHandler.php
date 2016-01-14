<?php
/**
 * Copyright (C) PT. Teknologi Kreasi Anak Bangsa (UrbanIndo.com) - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 */

namespace UrbanIndo\Yii2\Thrift\Component;

/**
 * ThriftHandler is base class for Thrift interface implementations.
 *
 * @author adinata
 */
abstract class ThriftHandler extends \yii\web\Controller implements ThriftHandlerInterface
{
    /**
     * Parsed Processor name.
     * @var [type]
     */
    private $_processorName;

    /**
     * Behaviors for controller.
     * @return array
     */
    public function behaviors()
    {
        return [];
    }

    /**
     * Handle exception thrown by thrift. Here the exception should be wrapped to known exception
     * in thrift metadata.
     * @param \Exception $exception Exception throwed from action execution.
     * @throws \Exception Rethrowed exception.
     * @return  void
     */
    public function handleException($exception)
    {
        throw $exception;
    }

    /**
     * By default it will use short processor class name and remove the 'Processor'
     * @return string
     * @throws \Exception Invalid processor.
     */
    public function getProcessorName()
    {
        if (!isset($this->_processorName)) {
            $tmp = explode('\\', $this->getProcessorClass());
            $candidate = end($tmp);
            $len = strlen($candidate);
            if (substr($candidate, $len - 9, 9) !== 'Processor') {  // 9 is length of 'Processor' word
                throw new \Exception('Invalid Processor class name');
            }
            $this->_processorName = substr($candidate, 0, $len - 9); // removing 'Processor' word
        }
        return $this->_processorName;
    }
}
