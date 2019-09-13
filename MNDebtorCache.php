<?php
namespace MNDebtorCache;

use Shopware\Components\Plugin;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class MNDebtorCache extends Plugin
{
    public static function getSubscribedEvents()
    {
        return [
            'Shopware_Plugins_HttpCache_ContextCookieValue' => 'onFilterCookies',
        ];
    }

    public function onFilterCookies(\Enlight_Event_EventArgs $args)
    {
        $hash = $args->getReturn();
        $session = $this->container->get('session');
        $b2b = $session->offsetGet('b2b_front_auth_identity');
        $userid = $session->offsetGet('sUserId');

        if (empty($b2b)) {
            return $hash;
        } else {
            return $hash . $userid;
        }
    }
}