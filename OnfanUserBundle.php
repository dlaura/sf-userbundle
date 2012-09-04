<?php

namespace Onfan\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

use Onfan\WSSEUserPasswordBundle\Security\Factory\Factory as WsseUserPasswordFactory;
use Onfan\WSSEAccessTokenBundle\Security\Factory\Factory as WsseAccessTokenFactory;


class OnfanUserBundle extends Bundle
{
    public function build(ContainerBuilder $container) {
        parent::build($container);
        
        $extension = $container->getExtension('security');
        $extension->addSecurityListenerFactory(new WsseUserPasswordFactory());
        $extension->addSecurityListenerFactory(new WsseAccessTokenFactory());
    }
}
