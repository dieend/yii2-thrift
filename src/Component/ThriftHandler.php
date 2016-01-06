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
abstract class ThriftHandler extends \yii\web\Controller implements ThriftHandlerInterface {
    private $_processorName;
    /**
     * Behaviors for controller.
     * @return array
     */
    public function behaviors() {
        
        return [];
    }
    
    /**
     * Handle exception thrown by thrift.
     * @param \Exception $exception
     * @throws \Exception
     */
    public function handleException($exception) {
        throw $exception;
    }

    /**
     * By default it will use short processor class name and remove the 'Processor'
     */
    public function getProcessorName() {
        if (!isset($this->_processorName)) {
            $candidate = end(explode('\\', $this->getProcessorClass()));
            $len = strlen($candidate);
            if (substr($candidate, $len - 9, 9) !== 'Processor') {  // 9 is length of 'Processor' word
                throw new \Exception("Invalid Processor class name");
            }
            $this->_processorName = substr($candidate, 0, $len - 9); // removing 'Processor' word
        }
        return $this->_processorName;
    }

}
