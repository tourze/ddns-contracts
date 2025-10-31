<?php

declare(strict_types=1);

namespace Tourze\DDNSContracts;

use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;
use Tourze\DDNSContracts\DTO\ExpectResolveResult;

/**
 * DDNS 服务提供商接口
 */
#[AutoconfigureTag(name: DNSProviderInterface::class)]
interface DNSProviderInterface
{
    public const TAG_NAME = 'ddns.dns.provider';

    /**
     * 获取提供商名称
     */
    public function getName(): string;

    /**
     * 检查这个解析结果，当前Provider是否需要处理
     */
    public function check(ExpectResolveResult $result): bool;

    /**
     * 处理当前DDNS结果
     */
    public function resolve(ExpectResolveResult $result): void;
}
