<?php

namespace Mic2100\IsTor\Subscriptions;

/**
 * IsTor?
 *
 * Subscription Interface
 *
 * @author Michael Bardsley @mic_bardsley
 */
interface SubscriptionInterface
{
    /**
     * Gets the addresses from the subscription
     *
     * @return \ArrayIterator
     */
    public function get();
}

