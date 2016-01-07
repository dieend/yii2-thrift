<?php
/**
 * Copyright (C) PT. Teknologi Kreasi Anak Bangsa (UrbanIndo.com) - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 */

namespace UrbanIndo\Yii2\Thrift\Component;

/**
 *
 * @author adinata
 */
interface ThriftHandlerInterface
{
    /**
     * Get processor class for this handler.
     * @return string
     */
    public function getProcessorClass();
    /**
     * Get processor name for this handler.
     * @return string
     */
    public function getProcessorName();
    /**
     * Handle throwed exception when running action.
     * @param  \Exception $exception Exception received when running action.
     * @return \Thrift\TException
     */
    public function handleException($exception);
}
