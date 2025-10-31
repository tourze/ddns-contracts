# DDNS Contracts

[![PHP](https://img.shields.io/badge/PHP-8.1%2B-blue.svg)](https://php.net)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](LICENSE)
[![Build Status](https://github.com/tourze/php-monorepo/workflows/CI/badge.svg)](https://github.com/tourze/php-monorepo/actions)
[![Coverage Status](https://coveralls.io/repos/github/tourze/php-monorepo/badge.svg?branch=master)](https://coveralls.io/github/tourze/php-monorepo?branch=master)

[English](README.md) | [中文](README.zh-CN.md)

为 PHP 应用程序提供 DDNS（动态DNS）服务合约定义。

## 功能特性

- **DNS 提供商接口**: 标准化的 DNS 服务提供商接口
- **IP 解析器接口**: 获取需要解析的 IP 地址的接口
- **自动配置**: 支持 Symfony 依赖注入和自动标记
- **类型安全**: 完整的 PHP 8.1+ 类型声明

## 依赖要求

- PHP 8.1 或更高版本
- Symfony Dependency Injection ^6.4

## 安装

```bash
composer require tourze/ddns-contracts
```

## 快速开始

此包提供用于实现 DDNS（动态DNS）服务的合约接口，包括：

- `DNSProviderInterface`: DNS 服务提供商接口
- `IPResolverInterface`: IP 地址解析器接口
- `ExpectResolveResult`: 期望解析结果的数据对象

```php
<?php

use Tourze\DDNSContracts\DNSProviderInterface;
use Tourze\DDNSContracts\DTO\ExpectResolveResult;

class MyDNSProvider implements DNSProviderInterface
{
    public function getName(): string
    {
        return 'my-dns-provider';
    }

    public function check(ExpectResolveResult $result): bool
    {
        // 检查此提供商是否应该处理此解析
        return str_ends_with($result->getDomainName(), '.example.com');
    }

    public function resolve(ExpectResolveResult $result): void
    {
        // 实现 DNS 解析逻辑
        $domain = $result->getDomainName();
        $ip = $result->getIpAddress();
        
        // 在此处实现您的 DNS 更新逻辑
    }
}
```

## 使用方法

### 实现 DNS 提供商

```php
use Tourze\DDNSContracts\DNSProviderInterface;
use Tourze\DDNSContracts\DTO\ExpectResolveResult;

class CloudflareDNSProvider implements DNSProviderInterface
{
    public function getName(): string
    {
        return 'cloudflare';
    }

    public function check(ExpectResolveResult $result): bool
    {
        // 仅处理由 Cloudflare 管理的域名
        return $this->isCloudflareManaged($result->getDomainName());
    }

    public function resolve(ExpectResolveResult $result): void
    {
        // 通过 Cloudflare API 更新 DNS 记录
        $this->updateCloudflareRecord(
            $result->getDomainName(),
            $result->getIpAddress()
        );
    }
}
```

### 实现 IP 解析器

```php
use Tourze\DDNSContracts\IPResolverInterface;
use Tourze\DDNSContracts\DTO\ExpectResolveResult;

class StaticIPResolver implements IPResolverInterface
{
    public function resolveAll(): iterable
    {
        yield new ExpectResolveResult('example.com', '192.168.1.100');
        yield new ExpectResolveResult('subdomain.example.com', '192.168.1.101');
    }
}
```

## 高级用法

### 自定义标记

接口会在 Symfony 的依赖注入容器中自动标记：

```yaml
# services.yaml
services:
    App\MyDNSProvider:
        tags:
            - { name: 'ddns.dns.provider' }
    
    App\MyIPResolver:
        tags:
            - { name: 'ddns:ip:resolver' }
```

### 多个提供商

您可以注册多个 DNS 提供商和 IP 解析器。系统将根据自动标记配置自动发现并使用它们。

## 配置

无需额外配置。该包使用 Symfony 的自动配置功能来自动注册实现所提供接口的服务。

## 许可证

此包基于 [MIT 许可证](LICENSE) 开源。
