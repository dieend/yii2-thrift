<?php

/**
 * Copyright (C) PT. Teknologi Kreasi Anak Bangsa (UrbanIndo.com) - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 */

namespace UrbanIndo\Yii2\Thrift\Component;

use Thrift\Protocol\TBinaryProtocol;
use Thrift\Protocol\TMultiplexedProtocol;
use Thrift\Transport\TBufferedTransport;
use Thrift\Transport\THttpClient;
use Yii;
use yii\base\Application;
use yii\base\Component;

/**
 * Description of ThriftClient
 *
 * @author adinata
 */
class ThriftClient extends Component {
    public $host;
    public $port;
    public $path;
    public $scheme;
    public $serviceName;
    public $serviceClass;
    private $_protocol;
    private $_client;
    private $_socket;
    public function init() {
        parent::init();
        $this->_socket= new THttpClient($this->host, $this->port, $this->path, $this->scheme);
        $transport = new TBufferedTransport($this->_socket, 1024, 1024);
        $this->_protocol = new TMultiplexedProtocol(new TBinaryProtocol($transport), $this->serviceName);
        
    }
    public function getClient() {
        if ($this->_client == null) {
            $transport = $this->_protocol->getTransport();
            $transport->open();
            $class = $this->serviceClass;
            $this->_client = new $class($this->_protocol);
            Yii::$app->on(Application::EVENT_AFTER_REQUEST, function ($event) use ($transport) {
                $transport->close();
            });
        }
        return $this->_client;
    }
    /**
     * 
     * @return THttpClient
     */
    public function addHeaders($headers) {
        $this->_socket->addHeaders($headers);
    }
}

