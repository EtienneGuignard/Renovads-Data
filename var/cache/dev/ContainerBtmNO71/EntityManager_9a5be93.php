<?php

namespace ContainerBtmNO71;
include_once \dirname(__DIR__, 4).''.\DIRECTORY_SEPARATOR.'vendor'.\DIRECTORY_SEPARATOR.'doctrine'.\DIRECTORY_SEPARATOR.'persistence'.\DIRECTORY_SEPARATOR.'src'.\DIRECTORY_SEPARATOR.'Persistence'.\DIRECTORY_SEPARATOR.'ObjectManager.php';
include_once \dirname(__DIR__, 4).''.\DIRECTORY_SEPARATOR.'vendor'.\DIRECTORY_SEPARATOR.'doctrine'.\DIRECTORY_SEPARATOR.'orm'.\DIRECTORY_SEPARATOR.'lib'.\DIRECTORY_SEPARATOR.'Doctrine'.\DIRECTORY_SEPARATOR.'ORM'.\DIRECTORY_SEPARATOR.'EntityManagerInterface.php';
include_once \dirname(__DIR__, 4).''.\DIRECTORY_SEPARATOR.'vendor'.\DIRECTORY_SEPARATOR.'doctrine'.\DIRECTORY_SEPARATOR.'orm'.\DIRECTORY_SEPARATOR.'lib'.\DIRECTORY_SEPARATOR.'Doctrine'.\DIRECTORY_SEPARATOR.'ORM'.\DIRECTORY_SEPARATOR.'EntityManager.php';

class EntityManager_9a5be93 extends \Doctrine\ORM\EntityManager implements \ProxyManager\Proxy\VirtualProxyInterface
{
    /**
     * @var \Doctrine\ORM\EntityManager|null wrapped object, if the proxy is initialized
     */
    private $valueHolderee123 = null;

    /**
     * @var \Closure|null initializer responsible for generating the wrapped object
     */
    private $initializer67e4f = null;

    /**
     * @var bool[] map of public properties of the parent class
     */
    private static $publicPropertiesc0e2d = [
        
    ];

    public function getConnection()
    {
        $this->initializer67e4f && ($this->initializer67e4f->__invoke($valueHolderee123, $this, 'getConnection', array(), $this->initializer67e4f) || 1) && $this->valueHolderee123 = $valueHolderee123;

        return $this->valueHolderee123->getConnection();
    }

    public function getMetadataFactory()
    {
        $this->initializer67e4f && ($this->initializer67e4f->__invoke($valueHolderee123, $this, 'getMetadataFactory', array(), $this->initializer67e4f) || 1) && $this->valueHolderee123 = $valueHolderee123;

        return $this->valueHolderee123->getMetadataFactory();
    }

    public function getExpressionBuilder()
    {
        $this->initializer67e4f && ($this->initializer67e4f->__invoke($valueHolderee123, $this, 'getExpressionBuilder', array(), $this->initializer67e4f) || 1) && $this->valueHolderee123 = $valueHolderee123;

        return $this->valueHolderee123->getExpressionBuilder();
    }

    public function beginTransaction()
    {
        $this->initializer67e4f && ($this->initializer67e4f->__invoke($valueHolderee123, $this, 'beginTransaction', array(), $this->initializer67e4f) || 1) && $this->valueHolderee123 = $valueHolderee123;

        return $this->valueHolderee123->beginTransaction();
    }

    public function getCache()
    {
        $this->initializer67e4f && ($this->initializer67e4f->__invoke($valueHolderee123, $this, 'getCache', array(), $this->initializer67e4f) || 1) && $this->valueHolderee123 = $valueHolderee123;

        return $this->valueHolderee123->getCache();
    }

    public function transactional($func)
    {
        $this->initializer67e4f && ($this->initializer67e4f->__invoke($valueHolderee123, $this, 'transactional', array('func' => $func), $this->initializer67e4f) || 1) && $this->valueHolderee123 = $valueHolderee123;

        return $this->valueHolderee123->transactional($func);
    }

    public function wrapInTransaction(callable $func)
    {
        $this->initializer67e4f && ($this->initializer67e4f->__invoke($valueHolderee123, $this, 'wrapInTransaction', array('func' => $func), $this->initializer67e4f) || 1) && $this->valueHolderee123 = $valueHolderee123;

        return $this->valueHolderee123->wrapInTransaction($func);
    }

    public function commit()
    {
        $this->initializer67e4f && ($this->initializer67e4f->__invoke($valueHolderee123, $this, 'commit', array(), $this->initializer67e4f) || 1) && $this->valueHolderee123 = $valueHolderee123;

        return $this->valueHolderee123->commit();
    }

    public function rollback()
    {
        $this->initializer67e4f && ($this->initializer67e4f->__invoke($valueHolderee123, $this, 'rollback', array(), $this->initializer67e4f) || 1) && $this->valueHolderee123 = $valueHolderee123;

        return $this->valueHolderee123->rollback();
    }

    public function getClassMetadata($className)
    {
        $this->initializer67e4f && ($this->initializer67e4f->__invoke($valueHolderee123, $this, 'getClassMetadata', array('className' => $className), $this->initializer67e4f) || 1) && $this->valueHolderee123 = $valueHolderee123;

        return $this->valueHolderee123->getClassMetadata($className);
    }

    public function createQuery($dql = '')
    {
        $this->initializer67e4f && ($this->initializer67e4f->__invoke($valueHolderee123, $this, 'createQuery', array('dql' => $dql), $this->initializer67e4f) || 1) && $this->valueHolderee123 = $valueHolderee123;

        return $this->valueHolderee123->createQuery($dql);
    }

    public function createNamedQuery($name)
    {
        $this->initializer67e4f && ($this->initializer67e4f->__invoke($valueHolderee123, $this, 'createNamedQuery', array('name' => $name), $this->initializer67e4f) || 1) && $this->valueHolderee123 = $valueHolderee123;

        return $this->valueHolderee123->createNamedQuery($name);
    }

    public function createNativeQuery($sql, \Doctrine\ORM\Query\ResultSetMapping $rsm)
    {
        $this->initializer67e4f && ($this->initializer67e4f->__invoke($valueHolderee123, $this, 'createNativeQuery', array('sql' => $sql, 'rsm' => $rsm), $this->initializer67e4f) || 1) && $this->valueHolderee123 = $valueHolderee123;

        return $this->valueHolderee123->createNativeQuery($sql, $rsm);
    }

    public function createNamedNativeQuery($name)
    {
        $this->initializer67e4f && ($this->initializer67e4f->__invoke($valueHolderee123, $this, 'createNamedNativeQuery', array('name' => $name), $this->initializer67e4f) || 1) && $this->valueHolderee123 = $valueHolderee123;

        return $this->valueHolderee123->createNamedNativeQuery($name);
    }

    public function createQueryBuilder()
    {
        $this->initializer67e4f && ($this->initializer67e4f->__invoke($valueHolderee123, $this, 'createQueryBuilder', array(), $this->initializer67e4f) || 1) && $this->valueHolderee123 = $valueHolderee123;

        return $this->valueHolderee123->createQueryBuilder();
    }

    public function flush($entity = null)
    {
        $this->initializer67e4f && ($this->initializer67e4f->__invoke($valueHolderee123, $this, 'flush', array('entity' => $entity), $this->initializer67e4f) || 1) && $this->valueHolderee123 = $valueHolderee123;

        return $this->valueHolderee123->flush($entity);
    }

    public function find($className, $id, $lockMode = null, $lockVersion = null)
    {
        $this->initializer67e4f && ($this->initializer67e4f->__invoke($valueHolderee123, $this, 'find', array('className' => $className, 'id' => $id, 'lockMode' => $lockMode, 'lockVersion' => $lockVersion), $this->initializer67e4f) || 1) && $this->valueHolderee123 = $valueHolderee123;

        return $this->valueHolderee123->find($className, $id, $lockMode, $lockVersion);
    }

    public function getReference($entityName, $id)
    {
        $this->initializer67e4f && ($this->initializer67e4f->__invoke($valueHolderee123, $this, 'getReference', array('entityName' => $entityName, 'id' => $id), $this->initializer67e4f) || 1) && $this->valueHolderee123 = $valueHolderee123;

        return $this->valueHolderee123->getReference($entityName, $id);
    }

    public function getPartialReference($entityName, $identifier)
    {
        $this->initializer67e4f && ($this->initializer67e4f->__invoke($valueHolderee123, $this, 'getPartialReference', array('entityName' => $entityName, 'identifier' => $identifier), $this->initializer67e4f) || 1) && $this->valueHolderee123 = $valueHolderee123;

        return $this->valueHolderee123->getPartialReference($entityName, $identifier);
    }

    public function clear($entityName = null)
    {
        $this->initializer67e4f && ($this->initializer67e4f->__invoke($valueHolderee123, $this, 'clear', array('entityName' => $entityName), $this->initializer67e4f) || 1) && $this->valueHolderee123 = $valueHolderee123;

        return $this->valueHolderee123->clear($entityName);
    }

    public function close()
    {
        $this->initializer67e4f && ($this->initializer67e4f->__invoke($valueHolderee123, $this, 'close', array(), $this->initializer67e4f) || 1) && $this->valueHolderee123 = $valueHolderee123;

        return $this->valueHolderee123->close();
    }

    public function persist($entity)
    {
        $this->initializer67e4f && ($this->initializer67e4f->__invoke($valueHolderee123, $this, 'persist', array('entity' => $entity), $this->initializer67e4f) || 1) && $this->valueHolderee123 = $valueHolderee123;

        return $this->valueHolderee123->persist($entity);
    }

    public function remove($entity)
    {
        $this->initializer67e4f && ($this->initializer67e4f->__invoke($valueHolderee123, $this, 'remove', array('entity' => $entity), $this->initializer67e4f) || 1) && $this->valueHolderee123 = $valueHolderee123;

        return $this->valueHolderee123->remove($entity);
    }

    public function refresh($entity)
    {
        $this->initializer67e4f && ($this->initializer67e4f->__invoke($valueHolderee123, $this, 'refresh', array('entity' => $entity), $this->initializer67e4f) || 1) && $this->valueHolderee123 = $valueHolderee123;

        return $this->valueHolderee123->refresh($entity);
    }

    public function detach($entity)
    {
        $this->initializer67e4f && ($this->initializer67e4f->__invoke($valueHolderee123, $this, 'detach', array('entity' => $entity), $this->initializer67e4f) || 1) && $this->valueHolderee123 = $valueHolderee123;

        return $this->valueHolderee123->detach($entity);
    }

    public function merge($entity)
    {
        $this->initializer67e4f && ($this->initializer67e4f->__invoke($valueHolderee123, $this, 'merge', array('entity' => $entity), $this->initializer67e4f) || 1) && $this->valueHolderee123 = $valueHolderee123;

        return $this->valueHolderee123->merge($entity);
    }

    public function copy($entity, $deep = false)
    {
        $this->initializer67e4f && ($this->initializer67e4f->__invoke($valueHolderee123, $this, 'copy', array('entity' => $entity, 'deep' => $deep), $this->initializer67e4f) || 1) && $this->valueHolderee123 = $valueHolderee123;

        return $this->valueHolderee123->copy($entity, $deep);
    }

    public function lock($entity, $lockMode, $lockVersion = null)
    {
        $this->initializer67e4f && ($this->initializer67e4f->__invoke($valueHolderee123, $this, 'lock', array('entity' => $entity, 'lockMode' => $lockMode, 'lockVersion' => $lockVersion), $this->initializer67e4f) || 1) && $this->valueHolderee123 = $valueHolderee123;

        return $this->valueHolderee123->lock($entity, $lockMode, $lockVersion);
    }

    public function getRepository($entityName)
    {
        $this->initializer67e4f && ($this->initializer67e4f->__invoke($valueHolderee123, $this, 'getRepository', array('entityName' => $entityName), $this->initializer67e4f) || 1) && $this->valueHolderee123 = $valueHolderee123;

        return $this->valueHolderee123->getRepository($entityName);
    }

    public function contains($entity)
    {
        $this->initializer67e4f && ($this->initializer67e4f->__invoke($valueHolderee123, $this, 'contains', array('entity' => $entity), $this->initializer67e4f) || 1) && $this->valueHolderee123 = $valueHolderee123;

        return $this->valueHolderee123->contains($entity);
    }

    public function getEventManager()
    {
        $this->initializer67e4f && ($this->initializer67e4f->__invoke($valueHolderee123, $this, 'getEventManager', array(), $this->initializer67e4f) || 1) && $this->valueHolderee123 = $valueHolderee123;

        return $this->valueHolderee123->getEventManager();
    }

    public function getConfiguration()
    {
        $this->initializer67e4f && ($this->initializer67e4f->__invoke($valueHolderee123, $this, 'getConfiguration', array(), $this->initializer67e4f) || 1) && $this->valueHolderee123 = $valueHolderee123;

        return $this->valueHolderee123->getConfiguration();
    }

    public function isOpen()
    {
        $this->initializer67e4f && ($this->initializer67e4f->__invoke($valueHolderee123, $this, 'isOpen', array(), $this->initializer67e4f) || 1) && $this->valueHolderee123 = $valueHolderee123;

        return $this->valueHolderee123->isOpen();
    }

    public function getUnitOfWork()
    {
        $this->initializer67e4f && ($this->initializer67e4f->__invoke($valueHolderee123, $this, 'getUnitOfWork', array(), $this->initializer67e4f) || 1) && $this->valueHolderee123 = $valueHolderee123;

        return $this->valueHolderee123->getUnitOfWork();
    }

    public function getHydrator($hydrationMode)
    {
        $this->initializer67e4f && ($this->initializer67e4f->__invoke($valueHolderee123, $this, 'getHydrator', array('hydrationMode' => $hydrationMode), $this->initializer67e4f) || 1) && $this->valueHolderee123 = $valueHolderee123;

        return $this->valueHolderee123->getHydrator($hydrationMode);
    }

    public function newHydrator($hydrationMode)
    {
        $this->initializer67e4f && ($this->initializer67e4f->__invoke($valueHolderee123, $this, 'newHydrator', array('hydrationMode' => $hydrationMode), $this->initializer67e4f) || 1) && $this->valueHolderee123 = $valueHolderee123;

        return $this->valueHolderee123->newHydrator($hydrationMode);
    }

    public function getProxyFactory()
    {
        $this->initializer67e4f && ($this->initializer67e4f->__invoke($valueHolderee123, $this, 'getProxyFactory', array(), $this->initializer67e4f) || 1) && $this->valueHolderee123 = $valueHolderee123;

        return $this->valueHolderee123->getProxyFactory();
    }

    public function initializeObject($obj)
    {
        $this->initializer67e4f && ($this->initializer67e4f->__invoke($valueHolderee123, $this, 'initializeObject', array('obj' => $obj), $this->initializer67e4f) || 1) && $this->valueHolderee123 = $valueHolderee123;

        return $this->valueHolderee123->initializeObject($obj);
    }

    public function getFilters()
    {
        $this->initializer67e4f && ($this->initializer67e4f->__invoke($valueHolderee123, $this, 'getFilters', array(), $this->initializer67e4f) || 1) && $this->valueHolderee123 = $valueHolderee123;

        return $this->valueHolderee123->getFilters();
    }

    public function isFiltersStateClean()
    {
        $this->initializer67e4f && ($this->initializer67e4f->__invoke($valueHolderee123, $this, 'isFiltersStateClean', array(), $this->initializer67e4f) || 1) && $this->valueHolderee123 = $valueHolderee123;

        return $this->valueHolderee123->isFiltersStateClean();
    }

    public function hasFilters()
    {
        $this->initializer67e4f && ($this->initializer67e4f->__invoke($valueHolderee123, $this, 'hasFilters', array(), $this->initializer67e4f) || 1) && $this->valueHolderee123 = $valueHolderee123;

        return $this->valueHolderee123->hasFilters();
    }

    /**
     * Constructor for lazy initialization
     *
     * @param \Closure|null $initializer
     */
    public static function staticProxyConstructor($initializer)
    {
        static $reflection;

        $reflection = $reflection ?? new \ReflectionClass(__CLASS__);
        $instance   = $reflection->newInstanceWithoutConstructor();

        \Closure::bind(function (\Doctrine\ORM\EntityManager $instance) {
            unset($instance->config, $instance->conn, $instance->metadataFactory, $instance->unitOfWork, $instance->eventManager, $instance->proxyFactory, $instance->repositoryFactory, $instance->expressionBuilder, $instance->closed, $instance->filterCollection, $instance->cache);
        }, $instance, 'Doctrine\\ORM\\EntityManager')->__invoke($instance);

        $instance->initializer67e4f = $initializer;

        return $instance;
    }

    protected function __construct(\Doctrine\DBAL\Connection $conn, \Doctrine\ORM\Configuration $config, \Doctrine\Common\EventManager $eventManager)
    {
        static $reflection;

        if (! $this->valueHolderee123) {
            $reflection = $reflection ?? new \ReflectionClass('Doctrine\\ORM\\EntityManager');
            $this->valueHolderee123 = $reflection->newInstanceWithoutConstructor();
        \Closure::bind(function (\Doctrine\ORM\EntityManager $instance) {
            unset($instance->config, $instance->conn, $instance->metadataFactory, $instance->unitOfWork, $instance->eventManager, $instance->proxyFactory, $instance->repositoryFactory, $instance->expressionBuilder, $instance->closed, $instance->filterCollection, $instance->cache);
        }, $this, 'Doctrine\\ORM\\EntityManager')->__invoke($this);

        }

        $this->valueHolderee123->__construct($conn, $config, $eventManager);
    }

    public function & __get($name)
    {
        $this->initializer67e4f && ($this->initializer67e4f->__invoke($valueHolderee123, $this, '__get', ['name' => $name], $this->initializer67e4f) || 1) && $this->valueHolderee123 = $valueHolderee123;

        if (isset(self::$publicPropertiesc0e2d[$name])) {
            return $this->valueHolderee123->$name;
        }

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolderee123;

            $backtrace = debug_backtrace(false, 1);
            trigger_error(
                sprintf(
                    'Undefined property: %s::$%s in %s on line %s',
                    $realInstanceReflection->getName(),
                    $name,
                    $backtrace[0]['file'],
                    $backtrace[0]['line']
                ),
                \E_USER_NOTICE
            );
            return $targetObject->$name;
        }

        $targetObject = $this->valueHolderee123;
        $accessor = function & () use ($targetObject, $name) {
            return $targetObject->$name;
        };
        $backtrace = debug_backtrace(true, 2);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $returnValue = & $accessor();

        return $returnValue;
    }

    public function __set($name, $value)
    {
        $this->initializer67e4f && ($this->initializer67e4f->__invoke($valueHolderee123, $this, '__set', array('name' => $name, 'value' => $value), $this->initializer67e4f) || 1) && $this->valueHolderee123 = $valueHolderee123;

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolderee123;

            $targetObject->$name = $value;

            return $targetObject->$name;
        }

        $targetObject = $this->valueHolderee123;
        $accessor = function & () use ($targetObject, $name, $value) {
            $targetObject->$name = $value;

            return $targetObject->$name;
        };
        $backtrace = debug_backtrace(true, 2);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $returnValue = & $accessor();

        return $returnValue;
    }

    public function __isset($name)
    {
        $this->initializer67e4f && ($this->initializer67e4f->__invoke($valueHolderee123, $this, '__isset', array('name' => $name), $this->initializer67e4f) || 1) && $this->valueHolderee123 = $valueHolderee123;

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolderee123;

            return isset($targetObject->$name);
        }

        $targetObject = $this->valueHolderee123;
        $accessor = function () use ($targetObject, $name) {
            return isset($targetObject->$name);
        };
        $backtrace = debug_backtrace(true, 2);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $returnValue = $accessor();

        return $returnValue;
    }

    public function __unset($name)
    {
        $this->initializer67e4f && ($this->initializer67e4f->__invoke($valueHolderee123, $this, '__unset', array('name' => $name), $this->initializer67e4f) || 1) && $this->valueHolderee123 = $valueHolderee123;

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolderee123;

            unset($targetObject->$name);

            return;
        }

        $targetObject = $this->valueHolderee123;
        $accessor = function () use ($targetObject, $name) {
            unset($targetObject->$name);

            return;
        };
        $backtrace = debug_backtrace(true, 2);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $accessor();
    }

    public function __clone()
    {
        $this->initializer67e4f && ($this->initializer67e4f->__invoke($valueHolderee123, $this, '__clone', array(), $this->initializer67e4f) || 1) && $this->valueHolderee123 = $valueHolderee123;

        $this->valueHolderee123 = clone $this->valueHolderee123;
    }

    public function __sleep()
    {
        $this->initializer67e4f && ($this->initializer67e4f->__invoke($valueHolderee123, $this, '__sleep', array(), $this->initializer67e4f) || 1) && $this->valueHolderee123 = $valueHolderee123;

        return array('valueHolderee123');
    }

    public function __wakeup()
    {
        \Closure::bind(function (\Doctrine\ORM\EntityManager $instance) {
            unset($instance->config, $instance->conn, $instance->metadataFactory, $instance->unitOfWork, $instance->eventManager, $instance->proxyFactory, $instance->repositoryFactory, $instance->expressionBuilder, $instance->closed, $instance->filterCollection, $instance->cache);
        }, $this, 'Doctrine\\ORM\\EntityManager')->__invoke($this);
    }

    public function setProxyInitializer(\Closure $initializer = null) : void
    {
        $this->initializer67e4f = $initializer;
    }

    public function getProxyInitializer() : ?\Closure
    {
        return $this->initializer67e4f;
    }

    public function initializeProxy() : bool
    {
        return $this->initializer67e4f && ($this->initializer67e4f->__invoke($valueHolderee123, $this, 'initializeProxy', array(), $this->initializer67e4f) || 1) && $this->valueHolderee123 = $valueHolderee123;
    }

    public function isProxyInitialized() : bool
    {
        return null !== $this->valueHolderee123;
    }

    public function getWrappedValueHolderValue()
    {
        return $this->valueHolderee123;
    }
}

if (!\class_exists('EntityManager_9a5be93', false)) {
    \class_alias(__NAMESPACE__.'\\EntityManager_9a5be93', 'EntityManager_9a5be93', false);
}
