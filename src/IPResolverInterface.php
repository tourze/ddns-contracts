<?php

declare(strict_types=1);

namespace Tourze\DDNSContracts;

use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;
use Tourze\DDNSContracts\DTO\ExpectResolveResult;

/**
 * IP 地址解析器接口
 */
#[AutoconfigureTag(name: IPResolverInterface::class)]
interface IPResolverInterface
{
    public const TAG_NAME = 'ddns:ip:resolver';

    /**
     * 返回所有应有效的解析记录
     *
     * @return iterable<ExpectResolveResult>
     */
    public function resolveAll(): iterable;
}
