<?php

namespace Framework;

class Container
{
    private $classMap = [];
    public $instanceMap = [];

    public function register($rootPath)
    {
        App::$configs = include $rootPath . 'config/common.php';

        $nosqls = ['redis'];
        foreach ($nosqls as $v) {
            $className = 'Framework\Nosql\\' . ucfirst($v);
            $this->setSingle($v, function () use ($className) {
                // lazy load
                return $className::init();
            });
        }
    }

    public function set($alias = '', $objectName = '')
    {
        $this->classMap[$alias] = $objectName;
        if (is_callable($objectName)) {
            return $objectName();
        }
        return new $objectName;
    }

    /**
     * get a instance from a class
     *
     * @param  string $alias
     * @return object
     */
    public function get($alias = '')
    {
        if (array_key_exists($alias, $this->classMap)) {
            if (is_callable($this->classMap[$alias])) {
                return $this->classMap[$alias]();
            }
            if (is_object($this->classMap[$alias])) {
                return $this->classMap[$alias];
            }
            return new $this->classMap[$alias];
        }
        throw new CoreHttpException(
            404,
            'Class:' . $alias
        );
    }

    /**
     * inject a sington class
     *
     * @param string $alias
     * @param object||closure||string $object
     * @return object
     */
    public function setSingle($alias = '', $object = '')
    {
        if (is_callable($alias)) {
            $instance  = $alias();
            $className = get_class($instance);
            $this->instanceMap[$className] = $instance;
            return $instance;
        }
        if (is_callable($object)) {
            if (empty($alias)) {
                throw new CoreHttpException(
                    400,
                    "{$alias} is empty"
                );
            }
            if (array_key_exists($alias, $this->instanceMap)) {
                return $this->instanceMap[$alias];
            }
            $this->instanceMap[$alias] = $object;
        }
        if (is_object($alias)) {
            $className = get_class($alias);
            if (array_key_exists($className, $this->instanceMap)) {
                return $this->instanceMap[$alias];
            }
            $this->instanceMap[$className] = $alias;
            return $this->instanceMap[$className];
        }
        if (is_object($object)) {
            if (empty($alias)) {
                throw new CoreHttpException(
                    400,
                    "{$alias} is empty"
                );
            }
            $this->instanceMap[$alias] = $object;
            return $this->instanceMap[$alias];
        }
        if (empty($alias) && empty($object)) {
            throw new CoreHttpException(
                400,
                "{$alias} and {$object} is empty"
            );
        }
        $this->instanceMap[$alias] = new $alias();
        return $this->instanceMap[$alias];
    }

    /**
     * get a sington instance
     *
     * @param  string  $alias
     * @param  Closure $closure
     * @return object
     */
    public function getSingle($alias = '', $closure = '')
    {
        if (array_key_exists($alias, $this->instanceMap)) {
            $instance = $this->instanceMap[$alias];
            if (is_callable($instance)) {
                return $this->instanceMap[$alias] = $instance();
            }
            return $instance;
        }

        if (is_callable($closure)) {
            return $this->instanceMap[$alias] = $closure();
        }

        throw new CoreHttpException(
            404,
            'Class:' . $alias
        );
    }
}
