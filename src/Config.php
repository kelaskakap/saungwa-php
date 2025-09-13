<?php

namespace Kelaskakap\SaungwaPhp;

final class Config
{
    private string $appKey;
    private string $authKey;
    private string $baseUri;
    private bool $sandbox;

    public function __construct(string $appKey, string $authKey, string $baseUri = 'https://app.saungwa.com/api', bool $sandbox = false)
    {
        $this->appKey = $appKey;
        $this->authKey = $authKey;
        $this->baseUri = rtrim($baseUri, '/');
        $this->sandbox = $sandbox;
    }

    public function getAppKey(): string
    {
        return $this->appKey;
    }
    public function getAuthKey(): string
    {
        return $this->authKey;
    }
    public function getBaseUri(): string
    {
        return $this->baseUri;
    }
    public function isSandbox(): bool
    {
        return $this->sandbox;
    }
}
