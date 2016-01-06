<?php

/**
 * Copyright (C) PT. Teknologi Kreasi Anak Bangsa (UrbanIndo.com) - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 */

namespace UrbanIndo\Yii2\Thrift\Component;

/**
 * Description of ThriftFormatter
 *
 * @author adinata
 */
class ThriftFormatter implements \yii\web\ResponseFormatterInterface {
    
    /**
     * @var string the Content-Type header for the response
     */
    public $contentType = 'application/x-thrift';
    /**
     * Format the content type of the response.
     * @param Response $response
     */
    public function format($response) {
        $response->getHeaders()->set('Content-Type', $this->contentType);
        if ($response->data !== null) {
            $response->content = $response->data;
        }
    }
}
