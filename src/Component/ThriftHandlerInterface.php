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
interface ThriftHandlerInterface {
    public function getProcessorClass();
    public function getProcessorName();
    public function handleException($exception);
}
