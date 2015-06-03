<?php

namespace Crm\AppBundle\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class EntityListener
{
    private $token_storage;

    public function __construct(TokenStorageInterface $token_storage) {
        $this->token_storage = $token_storage;
    }

    /**
     *
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args) {
        $entity = $args->getEntity();
        if (method_exists($entity, 'setUser')) {
            $entity->setUser($this->token_storage->getToken()->getUser());
        }
    }
}