# DDNS Contracts

[![PHP](https://img.shields.io/badge/PHP-8.1%2B-blue.svg)](https://php.net)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](LICENSE)
[![Build Status](https://github.com/tourze/php-monorepo/workflows/CI/badge.svg)](https://github.com/tourze/php-monorepo/actions)
[![Coverage Status](https://coveralls.io/repos/github/tourze/php-monorepo/badge.svg?branch=master)](https://coveralls.io/github/tourze/php-monorepo?branch=master)

[English](README.md) | [中文](README.zh-CN.md)

DDNS (Dynamic DNS) service contract definitions for PHP applications.

## Features

- **DNS Provider Interface**: Standardized interface for DNS service providers
- **IP Resolver Interface**: Interface for obtaining IP addresses that need resolution
- **Auto-configuration**: Symfony dependency injection support with auto-tagging
- **Type Safety**: Full PHP 8.1+ type declarations

## Dependencies

- PHP 8.1 or higher
- Symfony Dependency Injection ^6.4

## Installation

```bash
composer require tourze/ddns-contracts
```

## Quick Start

This package provides contract interfaces for implementing DDNS (Dynamic DNS) services. It includes:

- `DNSProviderInterface`: Interface for DNS service providers
- `IPResolverInterface`: Interface for IP address resolvers  
- `ExpectResolveResult`: Data object for expected resolution results

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
        // Check if this provider should handle the resolution
        return str_ends_with($result->getDomainName(), '.example.com');
    }

    public function resolve(ExpectResolveResult $result): void
    {
        // Implement DNS resolution logic
        $domain = $result->getDomainName();
        $ip = $result->getIpAddress();
        
        // Your DNS update logic here
    }
}
```

## Usage

### Implementing a DNS Provider

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
        // Only handle domains managed by Cloudflare
        return $this->isCloudflareManaged($result->getDomainName());
    }

    public function resolve(ExpectResolveResult $result): void
    {
        // Update DNS record via Cloudflare API
        $this->updateCloudflareRecord(
            $result->getDomainName(),
            $result->getIpAddress()
        );
    }
}
```

### Implementing an IP Resolver

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

## Advanced Usage

### Custom Tagging

The interfaces are automatically tagged in Symfony's dependency injection container:

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

### Multiple Providers

You can register multiple DNS providers and IP resolvers. The system will 
automatically discover and use them based on the auto-tagging configuration.

## Configuration

No additional configuration is required. The package uses Symfony's 
auto-configuration features to automatically register services that 
implement the provided interfaces.

## License

This package is open-sourced software licensed under the [MIT license](LICENSE).