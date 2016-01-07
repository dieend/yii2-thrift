<?php
/**
 *
 */

namespace UrbanIndo\Yii2\Thrift;

/**
 * ResponseFormatter set the response header as thrift application.
 *
 * @author Petra Barus <petra.barus@gmail.com>
 */
class ResponseFormatter extends \yii\base\Component implements \yii\web\ResponseFormatterInterface
{

    /**
     * @var string the Content-Type header for the response
     */
    public $contentType = 'application/x-thrift';

    /**
     * Format the content type of the response.
     * @param Response $response Response.
     * @return void
     */
    public function format($response)
    {
        $response->getHeaders()->set('Content-Type', $this->contentType);
    }
}
