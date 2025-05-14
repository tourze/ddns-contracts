<?php

declare(strict_types=1);

namespace Tourze\DDNSContracts\Tests;

use PHPUnit\Framework\TestCase;
use Tourze\DDNSContracts\ExpectResolveResult;

class ExpectResolveResultTest extends TestCase
{
    /**
     * 测试使用有效域名和IP地址创建对象
     */
    public function testConstruct_withValidParameters(): void
    {
        $domainName = 'example.com';
        $ipAddress = '192.168.1.1';
        
        $result = new ExpectResolveResult($domainName, $ipAddress);
        
        $this->assertInstanceOf(ExpectResolveResult::class, $result);
    }
    
    /**
     * 测试getDomainName方法返回正确的域名
     */
    public function testGetDomainName_returnsCorrectValue(): void
    {
        $domainName = 'example.com';
        $ipAddress = '192.168.1.1';
        
        $result = new ExpectResolveResult($domainName, $ipAddress);
        
        $this->assertSame($domainName, $result->getDomainName());
    }
    
    /**
     * 测试getIpAddress方法返回正确的IP地址
     */
    public function testGetIpAddress_returnsCorrectValue(): void
    {
        $domainName = 'example.com';
        $ipAddress = '192.168.1.1';
        
        $result = new ExpectResolveResult($domainName, $ipAddress);
        
        $this->assertSame($ipAddress, $result->getIpAddress());
    }
    
    /**
     * 测试使用子域名创建对象
     */
    public function testConstruct_withSubdomain(): void
    {
        $domainName = 'sub.example.com';
        $ipAddress = '192.168.1.1';
        
        $result = new ExpectResolveResult($domainName, $ipAddress);
        
        $this->assertSame($domainName, $result->getDomainName());
    }
    
    /**
     * 测试使用IPv6地址创建对象
     */
    public function testConstruct_withIpv6Address(): void
    {
        $domainName = 'example.com';
        $ipAddress = '2001:0db8:85a3:0000:0000:8a2e:0370:7334';
        
        $result = new ExpectResolveResult($domainName, $ipAddress);
        
        $this->assertSame($ipAddress, $result->getIpAddress());
    }
    
    /**
     * 测试使用空域名创建对象
     */
    public function testConstruct_withEmptyDomainName(): void
    {
        $domainName = '';
        $ipAddress = '192.168.1.1';
        
        $result = new ExpectResolveResult($domainName, $ipAddress);
        
        $this->assertSame($domainName, $result->getDomainName());
    }
    
    /**
     * 测试使用空IP地址创建对象
     */
    public function testConstruct_withEmptyIpAddress(): void
    {
        $domainName = 'example.com';
        $ipAddress = '';
        
        $result = new ExpectResolveResult($domainName, $ipAddress);
        
        $this->assertSame($ipAddress, $result->getIpAddress());
    }
    
    /**
     * 测试使用长域名创建对象
     */
    public function testConstruct_withLongDomainName(): void
    {
        $domainName = str_repeat('a', 253) . '.com'; // 最长有效域名为253个字符
        $ipAddress = '192.168.1.1';
        
        $result = new ExpectResolveResult($domainName, $ipAddress);
        
        $this->assertSame($domainName, $result->getDomainName());
    }
    
    /**
     * 测试使用特殊字符的域名创建对象
     */
    public function testConstruct_withSpecialCharactersInDomainName(): void
    {
        $domainName = 'xn--fiq228c.xn--fiqs8s'; // 中文域名的Punycode表示
        $ipAddress = '192.168.1.1';
        
        $result = new ExpectResolveResult($domainName, $ipAddress);
        
        $this->assertSame($domainName, $result->getDomainName());
    }
} 