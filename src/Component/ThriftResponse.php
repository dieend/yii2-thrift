<?php

/**
 * Copyright (C) PT. Teknologi Kreasi Anak Bangsa (UrbanIndo.com) - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 */

namespace UrbanIndo\Yii2\Thrift\Component;

/**
 * Description of Response
 *
 * @author adinata
 */
class ThriftResponse extends \yii\web\Response {
    const FORMAT_THRIFT = 'thrift';
    
    private $_headers;
    
    protected function defaultFormatters()
    {
        return array_merge([
                self::FORMAT_THRIFT => \common\components\thrift\ThriftFormatter::class,
            ], 
            parent::defaultFormatters()
        );
    }
    protected function sendHeaders()
    {
        if (headers_sent()) {
            return;
        }
        $statusCode = $this->getStatusCode();
        if ($this->format !== self::FORMAT_THRIFT) {
            header("HTTP/{$this->version} $statusCode {$this->statusText}");
        }
        if ($this->_headers) {
            $headers = $this->getHeaders();
            foreach ($headers as $name => $values) {
                $name = str_replace(' ', '-', ucwords(str_replace('-', ' ', $name)));
                // set replace for first occurrence of header but false afterwards to allow multiple
                $replace = true;
                foreach ($values as $value) {
                    header("$name: $value", $replace);
                    $replace = false;
                }
            }
        }
        $this->sendCookies();
    }
}
