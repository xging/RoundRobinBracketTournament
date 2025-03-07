<?php

namespace App\EventListener;

use App\Entity\Matches;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Monolog\Attribute\WithMonologChannel;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Predis\Client as RedisClient;
use App\Common\Traits\CacheTrait;

#[AsEventListener(event: Events::onFlush, method: 'onFlush')]
#[AsEventListener(event: Events::preUpdate, method: 'preUpdate')]
#[AsEventListener(event: Events::postUpdate, method: 'postUpdate')]
#[WithMonologChannel('cache_log')]
class CacheSubscriber
{
    use CacheTrait;

    public function __construct(private LoggerInterface $logger, RedisClient $redis)
    {
        $this->logger->info('CacheSubscriber instantiated with PHP 8 attribute');
        $this->setRedisClient($redis);
    }

    public function onFlush(OnFlushEventArgs $args): void
    {
        $this->logger->info('onFlush triggered');
    }

    public function preUpdate(PreUpdateEventArgs $args): void
    {

        $entity = $args->getObject();
        $changes = $args->getEntityChangeSet();

        $this->logger->info('preUpdate for entity: ' . get_class($entity), [
            'changes' => $changes,
        ]);
    }

    public function postUpdate(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();
        $entityName = $this->getEntityName($entity);

        if ($entity instanceof Matches) {
            $this->clearCache($entityName);
        }

        $this->logger->info('postUpdate for entity: ' . get_class($entity), [
            'id' => method_exists($entity, 'getId') ? $entity->getId() : null,
        ]);
    }

    private function getEntityName(object $entity): string
    {
        $className = get_class($entity);
        return basename(str_replace('\\', '/', $className)); // Возвращает только имя сущности
    }
}
