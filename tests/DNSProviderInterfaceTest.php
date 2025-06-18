<?php

declare(strict_types=1);

namespace Tourze\DDNSContracts\Tests;

use PHPUnit\Framework\TestCase;
use Tourze\DDNSContracts\DNSProviderInterface;
use Tourze\DDNSContracts\ExpectResolveResult;

class DNSProviderInterfaceTest extends TestCase
{
    /**
     * 用于测试的 DNSProviderInterface 实现类
     */
    private $mockProvider;
    
    /**
     * 设置测试环境
     */
    protected function setUp(): void
    {
        // 创建一个实现 DNSProviderInterface 的模拟对象
        $this->mockProvider = $this->createMock(DNSProviderInterface::class);
    }
    
    /**
     * 测试 getName 方法定义是否正确
     */
    public function testGetName_methodDefinition(): void
    {
        // 设置 getName 方法的返回值
        $this->mockProvider->method('getName')->willReturn('mock-provider');
        
        // 断言方法返回预期的值
        $this->assertSame('mock-provider', $this->mockProvider->getName());
        
        // 断言方法返回值类型
        $this->assertIsString($this->mockProvider->getName());
    }
    
    /**
     * 测试 check 方法定义是否正确
     */
    public function testCheck_methodDefinition(): void
    {
        // 创建一个测试用的 ExpectResolveResult 对象
        $result = new ExpectResolveResult('example.com', '192.168.1.1');
        
        // 设置 check 方法的返回值
        $this->mockProvider->method('check')->willReturn(true);
        
        // 断言方法返回预期的值
        $this->assertTrue($this->mockProvider->check($result));
        
        // 断言方法返回值类型
        $this->assertIsBool($this->mockProvider->check($result));
    }
    
    /**
     * 测试 check 方法接收 ExpectResolveResult 参数
     */
    public function testCheck_acceptsExpectResolveResult(): void
    {
        // 创建一个测试用的 ExpectResolveResult 对象
        $result = new ExpectResolveResult('example.com', '192.168.1.1');
        
        // 设置 check 方法期望接收 ExpectResolveResult 类型的参数并返回 true
        $this->mockProvider->expects($this->once())
            ->method('check')
            ->with($this->isInstanceOf(ExpectResolveResult::class))
            ->willReturn(true);
        
        // 调用 check 方法
        $this->mockProvider->check($result);
    }
    
    /**
     * 测试 resolve 方法定义是否正确
     */
    public function testResolve_methodDefinition(): void
    {
        // 创建一个测试用的 ExpectResolveResult 对象
        $result = new ExpectResolveResult('example.com', '192.168.1.1');
        
        // 由于 resolve 方法返回 void，我们只需测试能否正常调用
        $this->mockProvider->expects($this->once())
            ->method('resolve')
            ->with($this->isInstanceOf(ExpectResolveResult::class));
            
        // 调用 resolve 方法
        $this->mockProvider->resolve($result);
        
        // 不需要断言返回值，因为返回类型是 void
        $this->addToAssertionCount(1);
    }
    
    /**
     * 测试 resolve 方法接收 ExpectResolveResult 参数
     */
    public function testResolve_acceptsExpectResolveResult(): void
    {
        // 创建一个测试用的 ExpectResolveResult 对象
        $result = new ExpectResolveResult('example.com', '192.168.1.1');
        
        // 设置 resolve 方法期望接收 ExpectResolveResult 类型的参数
        $this->mockProvider->expects($this->once())
            ->method('resolve')
            ->with($this->isInstanceOf(ExpectResolveResult::class));
        
        // 调用 resolve 方法
        $this->mockProvider->resolve($result);
    }
    
    /**
     * 测试接口常量 TAG_NAME 定义是否正确
     */
    public function testTagNameConstant_isCorrectlyDefined(): void
    {
        $this->assertSame('ddns.dns.provider', DNSProviderInterface::TAG_NAME);
    }
} 