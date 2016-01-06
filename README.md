# yii2-thrift
Thrift extension for Yii2

[![Latest Stable Version](https://poser.pugx.org/urbanindo/yii2-thrift/v/stable.svg)](https://packagist.org/packages/urbanindo/yii2-thrift)
[![Total Downloads](https://poser.pugx.org/urbanindo/yii2-thrift/downloads.svg)](https://packagist.org/packages/urbanindo/yii2-thrift)
[![Latest Unstable Version](https://poser.pugx.org/urbanindo/yii2-thrift/v/unstable.svg)](https://packagist.org/packages/urbanindo/yii2-thrift)
[![Build Status](https://travis-ci.org/urbanindo/yii2-thrift.svg)](https://travis-ci.org/urbanindo/yii2-thrift)

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist urbanindo/yii2-thrift "*"
```

or add

```
"urbanindo/yii2-thrift": "*"
```


# Minimum Requirement

- Thrift version 0.9.2.
  To install thrift, check http://thrift.apache.org/download
- Yii 2.0.0

# Usage
There are 2 possible way to uses this repository.

## Usage 1
This is the preferred way. It will seamlessly integrated with your existing web application
and only need to add one endpoint. But it requires you to uses http(s) transport and multiplexed
protocol. For using default transport, see Usage 2.

### Using server:
Create thrift processor, by creating a new class that extends `ThriftHandler` and implementing
generated interface from thrift metadata. This handler class extended from `\yii\web\Controller`,
so you can add `beforeAction`, `behaviors`, etc. `handleException` will catch normal exception,
and you should wrap this exception into exception that defined in your thrift metadata, and throw
it again so `Thrift` understood the exception and can return it to your client.

Create an endpoint controller, e.g. `ServicesController` which extends abstract class
`ThriftController`. All client will uses `{http://your.domain}/services` to access the thrift server.
`getHandlerClasses` should return array that point multiplex key to it's handler.


// TODO create code example

### Using client:
```
```

## Usage 2
Put the thrift file into some directory `thrift` in the root is preferable.

Generate the thrift file using command below.

```
thrift --gen php:server,oop path/to/the/thrift/file
```

In the `index.php` instead of using the default `yii\web\Application` use 
`UrbanIndo\Yii2\Thrift\Application`.

In the component configuration add the `thrift` configuration.

```php
return [
    'component' => [
        'thrift' => [
            'serviceMap' => [
                '' => 'service'
            ]
        ]
    ]
]
```

Create a service in the `services` directory, similar to `controllers`. 
This should implement both the Interface from generated Thrift file **and**
`UrbanIndo\Yii2\Thrift\Service` interface.

```php
class HelloService implements \myservice\HelloServiceIf, \UrbanIndo\Yii2\Thrift\Service {

    public function getProcessorClass {
        return 'myservice\HelloServiceProcessor';
    }
}
```