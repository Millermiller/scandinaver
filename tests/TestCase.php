<?php

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;

abstract class TestCase extends BaseTestCase
{
    use DatabaseMigrations;

    public function createApplication()
    {
        $unitTesting = true;
        $testEnvironment = 'testing';
        return require __DIR__.'/../bootstrap/app.php';
    }

    protected function setUp(): void
    {
        if (file_exists(__DIR__.'/../bootstrap/cache/config.php')) {
            unlink(__DIR__.'/../bootstrap/cache/config.php');
        }

        parent::setUp();
        $this->prepareForTests();
        $this->withoutMiddleware(\App\Http\Middleware\Cors::class);
    }
    private function prepareForTests()
    {
        \Config::set('migrations.default.directory', database_path('migrations_test'));
        Artisan::call('doctrine:migrations:migrate');
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }

}
