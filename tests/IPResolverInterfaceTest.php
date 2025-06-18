<?php

declare(strict_types=1);

namespace Tourze\DDNSContracts\Tests;

use PHPUnit\Framework\TestCase;
use Tourze\DDNSContracts\ExpectResolveResult;
use Tourze\DDNSContracts\IPResolverInterface;

class IPResolverInterfaceTest extends TestCase
{
    /**
     * 用于测试的 IPResolverInterface 实现类
     */
    private $mockResolver;
    
    /**
     * 设置测试环境
     */
    protected function setUp(): void
    {
        // 创建一个实现 IPResolverInterface 的模拟对象
        $this->mockResolver = $this->createMock(IPResolverInterface::class);
    }
    
    /**
     * 测试 resolveAll 方法返回可迭代对象
     */
    public function testResolveAll_returnsIterable(): void
    {
        // 创建一些 ExpectResolveResult 对象用于测试
        $result1 = new ExpectResolveResult('example.com', '192.168.1.1');
        $result2 = new ExpectResolveResult('test.com', '192.168.1.2');
        
        // 设置 resolveAll 方法返回一个数组
        $this->mockResolver->method('resolveAll')->willReturn([$result1, $result2]);
        
        // 断言方法返回的是可迭代对象
        $this->assertIsIterable($this->mockResolver->resolveAll());
    }
    
    /**
     * 测试 resolveAll 方法返回的集合元素为 ExpectResolveResult 类型
     */
    public function testResolveAll_returnsExpectResolveResultCollection(): void
    {
        // 创建一些 ExpectResolveResult 对象用于测试
        $result1 = new ExpectResolveResult('example.com', '192.168.1.1');
        $result2 = new ExpectResolveResult('test.com', '192.168.1.2');
        
        // 设置 resolveAll 方法返回一个数组
        $this->mockResolver->method('resolveAll')->willReturn([$result1, $result2]);
        
        // 断言返回集合中的元素都是 ExpectResolveResult 类型
        foreach ($this->mockResolver->resolveAll() as $item) {
            $this->assertInstanceOf(ExpectResolveResult::class, $item);
        }
    }
    
    /**
     * 测试 resolveAll 方法返回空集合的情况
     */
    public function testResolveAll_withEmptyCollection(): void
    {
        // 设置 resolveAll 方法返回一个空数组
        $this->mockResolver->method('resolveAll')->willReturn([]);
        
        // 断言返回的是一个空集合
        $this->assertEmpty($this->mockResolver->resolveAll());
        $this->assertCount(0, $this->mockResolver->resolveAll());
    }
    
    /**
     * 测试 resolveAll 方法返回的集合中包含多个元素的情况
     */
    public function testResolveAll_withMultipleItems(): void
    {
        // 创建多个 ExpectResolveResult 对象用于测试
        $results = [
            new ExpectResolveResult('example.com', '192.168.1.1'),
            new ExpectResolveResult('test.com', '192.168.1.2'),
            new ExpectResolveResult('demo.com', '192.168.1.3')
        ];
        
        // 设置 resolveAll 方法返回多个元素的数组
        $this->mockResolver->method('resolveAll')->willReturn($results);
        
        // 断言返回集合中包含预期数量的元素
        $this->assertCount(3, $this->mockResolver->resolveAll());
    }
    
    /**
     * 测试接口常量 TAG_NAME 定义是否正确
     */
    public function testTagNameConstant_isCorrectlyDefined(): void
    {
        $this->assertSame('ddns:ip:resolver', IPResolverInterface::TAG_NAME);
    }
    
    /**
     * 测试 resolveAll 方法返回的是生成器的情况
     */
    public function testResolveAll_withGenerator(): void
    {
        // 创建一个会返回生成器的回调函数
        $generatorCallback = function () {
            yield new ExpectResolveResult('example.com', '192.168.1.1');
            yield new ExpectResolveResult('test.com', '192.168.1.2');
        };
        
        // 设置 resolveAll 方法返回一个生成器
        $this->mockResolver->method('resolveAll')->willReturn($generatorCallback());
        
        // 断言返回的是一个可迭代对象
        $this->assertIsIterable($this->mockResolver->resolveAll());
        
        // 断言能够成功遍历返回的生成器并获取值
        $results = [];
        foreach ($this->mockResolver->resolveAll() as $item) {
            $results[] = $item;
        }
        
        $this->assertCount(2, $results);
        $this->assertInstanceOf(ExpectResolveResult::class, $results[0]);
        $this->assertInstanceOf(ExpectResolveResult::class, $results[1]);
    }
} 