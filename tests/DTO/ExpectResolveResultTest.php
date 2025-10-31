<?php

declare(strict_types=1);

namespace Tourze\DDNSContracts\Tests\DTO;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Tourze\DDNSContracts\DTO\ExpectResolveResult;

/**
 * @internal
 */
#[CoversClass(ExpectResolveResult::class)]
final class ExpectResolveResultTest extends TestCase
{
    /**
     * 测试使用有效域名和IP地址创建对象
     */
    public function testConstructWithValidParameters(): void
    {
        $domainName = 'example.com';
        $ipAddress = '192.168.1.1';

        $result = new ExpectResolveResult($domainName, $ipAddress);

        $this->assertInstanceOf(ExpectResolveResult::class, $result);
    }

    /**
     * 测试getDomainName方法返回正确的域名
     */
    public function testGetDomainNameReturnsCorrectValue(): void
    {
        $domainName = 'example.com';
        $ipAddress = '192.168.1.1';

        $result = new ExpectResolveResult($domainName, $ipAddress);

        $this->assertSame($domainName, $result->getDomainName());
    }

    /**
     * 测试getIpAddress方法返回正确的IP地址
     */
    public function testGetIpAddressReturnsCorrectValue(): void
    {
        $domainName = 'example.com';
        $ipAddress = '192.168.1.1';

        $result = new ExpectResolveResult($domainName, $ipAddress);

        $this->assertSame($ipAddress, $result->getIpAddress());
    }

    /**
     * 测试使用子域名创建对象
     */
    public function testConstructWithSubdomain(): void
    {
        $domainName = 'sub.example.com';
        $ipAddress = '192.168.1.1';

        $result = new ExpectResolveResult($domainName, $ipAddress);

        $this->assertSame($domainName, $result->getDomainName());
    }

    /**
     * 测试使用IPv6地址创建对象
     */
    public function testConstructWithIpv6Address(): void
    {
        $domainName = 'example.com';
        $ipAddress = '2001:0db8:85a3:0000:0000:8a2e:0370:7334';

        $result = new ExpectResolveResult($domainName, $ipAddress);

        $this->assertSame($ipAddress, $result->getIpAddress());
    }

    /**
     * 测试使用空域名创建对象
     */
    public function testConstructWithEmptyDomainName(): void
    {
        $domainName = '';
        $ipAddress = '192.168.1.1';

        $result = new ExpectResolveResult($domainName, $ipAddress);

        $this->assertSame($domainName, $result->getDomainName());
    }

    /**
     * 测试使用空IP地址创建对象
     */
    public function testConstructWithEmptyIpAddress(): void
    {
        $domainName = 'example.com';
        $ipAddress = '';

        $result = new ExpectResolveResult($domainName, $ipAddress);

        $this->assertSame($ipAddress, $result->getIpAddress());
    }

    /**
     * 测试使用长域名创建对象
     */
    public function testConstructWithLongDomainName(): void
    {
        $domainName = str_repeat('a', 253) . '.com'; // 最长有效域名为253个字符
        $ipAddress = '192.168.1.1';

        $result = new ExpectResolveResult($domainName, $ipAddress);

        $this->assertSame($domainName, $result->getDomainName());
    }

    /**
     * 测试使用特殊字符的域名创建对象
     */
    public function testConstructWithSpecialCharactersInDomainName(): void
    {
        $domainName = 'xn--fiq228c.xn--fiqs8s'; // 中文域名的Punycode表示
        $ipAddress = '192.168.1.1';

        $result = new ExpectResolveResult($domainName, $ipAddress);

        $this->assertSame($domainName, $result->getDomainName());
    }
}
