<?php

namespace App;

class Subscription
{
    /**
     * @var Gateway
     */
    protected $gateway;
    /**
     * @var Mailer
     */
    protected $mailer;

    public function __construct(Gateway $gateway, Mailer $mailer)
    {
        $this->gateway = $gateway;
        $this->mailer = $mailer;
     }

    public function create(User $user)
    {
        // create the subscription through Stripe.
        $receipt = $this->gateway->create();

        // Update the local user record.
        $user->markAsSubscribed();

        // Send a welcome email or dispatch event.
        $this->mailer->deliver('Your receipt number is: ' . $receipt);
    }
}
