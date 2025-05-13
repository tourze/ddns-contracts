<?php

namespace Tourze\DDNSContracts;

/**
 * 期望的解析结果
 */
class ExpectResolveResult
{
    public function __construct(
        private readonly string $domainName,
        private readonly string $ipAddress,
    )
    {
    }

    public function getDomainName(): string
    {
        return $this->domainName;
    }

    public function getIpAddress(): string
    {
        return $this->ipAddress;
    }
}
