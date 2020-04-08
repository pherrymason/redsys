<?php

namespace Sepia\Redsys\PaymentRequest;

final class SiteUrls
{
    /** @var string */
    private $okUrl;
    /** @var string */
    private $koUrl;
    /** @var string|null */
    private $notificationUrl;

    public function __construct(string $okUrl, string $koUrl, ?string $notificationUrl = null)
    {
        $this->okUrl = $okUrl;
        $this->koUrl = $koUrl;
        $this->notificationUrl = $notificationUrl;
    }

    public function okUrl(): string
    {
        return $this->okUrl;
    }

    public function koUrl(): string
    {
        return $this->koUrl;
    }

    public function notificationUrl(): ?string
    {
        return $this->notificationUrl;
    }
}
