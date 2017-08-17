<?php

namespace airani\flysystem;

use Yii;
use yii\base\Configurable;
use yii\base\InvalidConfigException;
use yii\base\UnknownPropertyException;
use yii\di\Container;
use yii\helpers\ArrayHelper;

/**
 * Flysystem MountManager as Yii2 component
 * @author Ali Irani <ali@irani.im>
 */
class MountManager extends \League\Flysystem\MountManager implements Configurable
{
    private $_filesystems = [];

    /**
     * Compatible with configurable Yii2 object
     * @inheritdoc
     */
    public function __construct($config = [])
    {
        if (!empty($config)) {
            Yii::configure($this, $config);
        }

        $this->mountFilesystems($this->_filesystems);
    }

    /**
     * Create and config filesystem adapter
     */
    public function __set($name, $config)
    {
        $class = ArrayHelper::remove($config, 'class');

        if ($class === null) {
            throw new InvalidConfigException('$class must be set for an adapter of Filesystem');
        }

        $reflection = new \ReflectionClass($class);
        $constructParams = [];

        foreach ($reflection->getConstructor()->getParameters() as $param) {
            $constructParams[] = ArrayHelper::getValue($config, $param->name, $param->isDefaultValueAvailable() ? $param->getDefaultValue() : null);
        }

        $container = new Container();
        $container->set('League\Flysystem\AdapterInterface', $class, $constructParams);
        $container->set('Filesystem', 'League\Flysystem\Filesystem');

        $this->_filesystems[$name] = $container->get('Filesystem');
    }

    /**
     * Getting filesystem object with mount manager prefix name
     */
    public function __get($name)
    {
        if (array_key_exists($name, $this->_filesystems) === false) {
            throw new UnknownPropertyException('Getting unknown property: ' . get_class($this) . '::' . $name);
        }

        return $this->_filesystems[$name];
    }
}
