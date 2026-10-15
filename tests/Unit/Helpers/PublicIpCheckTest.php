<?php

namespace Tests\Unit\Helpers;

use App\Helpers\PublicIpCheck;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class PublicIpCheckTest extends TestCase
{
    public static function publicProvider(): array
    {
        return [
            'public ipv4 google' => ['8.8.8.8'],
            'public ipv4 cloudflare' => ['1.1.1.1'],
            'public ipv6 cloudflare' => ['2606:4700:4700::1111'],
            'public ipv6 google' => ['2001:4860:4860::8888'],
            'v4-mapped public v4' => ['::ffff:8.8.8.8'],
            'nat64 public target' => ['64:ff9b::8.8.8.8'],
            'nat64 public target hex' => ['64:ff9b::808:808'],
            '6to4 public target' => ['2002:0808:0808::'],
        ];
    }

    public static function nonPublicProvider(): array
    {
        return [
            // Loopback
            'ipv4 loopback' => ['127.0.0.1'],
            'ipv4 loopback high' => ['127.255.255.254'],
            'ipv6 loopback' => ['::1'],

            // RFC-1918 private
            'rfc1918 10' => ['10.0.0.1'],
            'rfc1918 172' => ['172.16.5.5'],
            'rfc1918 192' => ['192.168.1.1'],

            // Link-local (AWS/GCP/Azure IMDS lives here)
            'link-local v4' => ['169.254.169.254'],
            'link-local v6' => ['fe80::1'],

            // IPv6 unique local
            'unique local fc' => ['fc00::1'],
            'unique local fd' => ['fd12:3456::1'],

            // Unspecified
            'unspecified v4' => ['0.0.0.0'],
            'unspecified v6' => ['::'],

            // IPv4-mapped IPv6 wrapping a private target
            'v4-mapped loopback' => ['::ffff:127.0.0.1'],
            'v4-mapped rfc1918' => ['::ffff:10.0.0.1'],
            'v4-mapped imds' => ['::ffff:169.254.169.254'],

            // NAT64 wrapping non-public targets (GHSA-5j6m-rr83-rpj7)
            'nat64 loopback dotted' => ['64:ff9b::127.0.0.1'],
            'nat64 loopback hex' => ['64:ff9b::7f00:1'],
            'nat64 imds dotted' => ['64:ff9b::169.254.169.254'],
            'nat64 imds hex' => ['64:ff9b::a9fe:a9fe'],
            'nat64 rfc1918' => ['64:ff9b::10.0.0.1'],

            // 6to4 wrapping non-public targets
            '6to4 loopback' => ['2002:7f00:1::'],
            '6to4 imds' => ['2002:a9fe:a9fe::'],
            '6to4 rfc1918' => ['2002:0a00:1::'],

            // Teredo wrapping non-public target
            // client IPv4 in bits 96-127 XOR'd with 0xffffffff
            // 10.0.0.1 -> XOR'd = f5ff:fffe
            'teredo rfc1918' => ['2001:0000:4136:e378:8000:63bf:f5ff:fffe'],

            // Garbage
            'not an ip' => ['not-an-ip'],
            'empty string' => [''],
        ];
    }

    #[DataProvider('publicProvider')]
    public function test_recognizes_publicly_routable_addresses(string $ip): void
    {
        $this->assertTrue(
            PublicIpCheck::isPublic($ip),
            $ip.' should be considered publicly routable',
        );
    }

    #[DataProvider('nonPublicProvider')]
    public function test_rejects_non_public_addresses(string $ip): void
    {
        $this->assertFalse(
            PublicIpCheck::isPublic($ip),
            $ip.' should NOT be considered publicly routable',
        );
    }
}
