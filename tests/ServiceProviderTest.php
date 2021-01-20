<?php


use Illuminate\Contracts\Foundation\Application;
use Maknz\Slack\Laravel\ServiceProvider;
use Maknz\Slack\Laravel\ServiceProviderLaravel8;
use PHPUnit\Framework\TestCase;

class ServiceProviderTest extends TestCase
{
    /** @test */
    public function it_loads_correct_laravel_service_provider_if_php_version_is_8()
    {
        $app = Mockery::mock(Application::class);
        $app->shouldReceive('version')->andReturn('8.23.1');
        $serviceProvider = new ServiceProvider($app);
        $reflectionClass = new ReflectionClass($serviceProvider);
        $property = $reflectionClass->getProperty('provider');
        $property->setAccessible(true);
        $this->assertInstanceOf(ServiceProviderLaravel8::class, $property->getValue($serviceProvider));
    }

    /** @test */
    public function it_throws_exception_if_php_version_is_7()
    {
        $this->expectException(RuntimeException::class);
        $app = Mockery::mock(Application::class);
        $app->shouldReceive('version')->andReturn('7.30.3');
        new ServiceProvider($app);
    }

    /** @test */
    public function it_throws_exception_if_php_version_is_6()
    {
        $this->expectException(RuntimeException::class);
        $app = Mockery::mock(Application::class);
        $app->shouldReceive('version')->andReturn('6.20.13');
        new ServiceProvider($app);
    }

    /** @test */
    public function it_throws_exception_if_php_version_is_5()
    {
        $this->expectException(RuntimeException::class);
        $app = Mockery::mock(Application::class);
        $app->shouldReceive('version')->andReturn('5.0.35');
        new ServiceProvider($app);
    }

    /** @test */
    public function it_throws_exception_if_php_version_is_4()
    {
        $this->expectException(RuntimeException::class);
        $app = Mockery::mock(Application::class);
        $app->shouldReceive('version')->andReturn('4.2.22');
        new ServiceProvider($app);
    }
}
