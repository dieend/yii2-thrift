<?php
/**
 *
 */

namespace UrbanIndo\Yii2\Thrift;

use Thrift\Transport\TBufferedTransport;
use Thrift\Transport\TPhpStream;
use Thrift\Protocol\TBinaryProtocol;

/**
 * Response
 * @author Petra Barus <petra.barus@gmail.com>
 */
class Response extends \yii\web\Response
{
    
    const FORMAT_THRIFT = 'thrift';
    /**
     * Default format thrift
     * @var string
     */
    public $format = self::FORMAT_THRIFT;
    
    /**
     * Define thrift transport.
     * @var \Thrift\Transport\TTransport
     */
    private $_transport;
    
    /**
     * Define the thrift protocol.
     * @var \Thrift\Protocol\TProtocol
     */
    private $_protocol;
    
    /**
     * @var object
     */
    private $_processor;
    
    /**
     * Initialize the response.
     * @return void
     */
    public function init()
    {
        parent::init();
        $this->formatters = [
            self::FORMAT_THRIFT => 'UrbanIndo\Yii2\Thrift\ResponseFormatter',
        ];
        $this->_transport = new TBufferedTransport(new TPhpStream(TPhpStream::MODE_R | TPhpStream::MODE_W));
        $this->_protocol = new TBinaryProtocol($this->_transport, true, true);
    }
    
    /**
     * @param object $processor Processor.
     * @return void
     */
    public function setProcessor($processor)
    {
        $this->_processor = $processor;
    }
    
    /**
     * Send the result.
     * @return  void
     */
    public function send()
    {
        //PS: I think this is a bit wrong. But this works, for now.
        $this->_transport->open();
        $this->_processor->process($this->_protocol, $this->_protocol);
        $this->_transport->close();
        parent::send();
    }
}
