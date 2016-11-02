<?php

namespace xmarcos\Silex;

use Silex\Application;
use Elasticsearch\ClientBuilder;
use InvalidArgumentException;
use Pimple\ServiceProviderInterface;

class ElasticsearchServiceProvider implements ServiceProviderInterface
{
    protected $prefix;

    /**
     * @param string $prefix Prefix name used to register the service in Silex.
     */
    public function __construct($prefix = 'elasticsearch')
    {
        if (empty($prefix) || false === is_string($prefix)) {
            throw new InvalidArgumentException(
                sprintf('$prefix must be a non-empty string, "%s" given', gettype($prefix))
            );
        }

        $this->prefix = $prefix;
    }

    /**
     * {@inheritdoc}
     */
    public function register(\Pimple\Container $app)
    {
        $prefix           = $this->prefix;
        $params_key       = sprintf('%s.params', $prefix);
        $app['elasticsearch'] = function($app) use($params_key) {
            return ClientBuilder::fromConfig($params_key);
        };
    }

}
