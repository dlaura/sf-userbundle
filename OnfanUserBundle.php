<?php

namespace Onfan\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

use Onfan\WSSEUserPasswordBundle\Security\Factory\Factory as WsseUserPasswordFactory;
use Onfan\WSSEAccessTokenBundle\Security\Factory\Factory as WsseAccessTokenFactory;
use Onfan\WSSEFacebookTokenBundle\Security\Factory\Factory as WsseFacebookTokenFactory;


class OnfanUserBundle extends Bundle
{
    public function build(ContainerBuilder $container) {
        parent::build($container);
        
        $extension = $container->getExtension('security');
        $extension->addSecurityListenerFactory(new WsseUserPasswordFactory());
        $extension->addSecurityListenerFactory(new WsseAccessTokenFactory());
        $extension->addSecurityListenerFactory(new WsseFacebookTokenFactory());
    }
}
