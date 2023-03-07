<?php
namespace Tests\Unit;

use App\Models\User;
use App\Models\Setting;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase; 
use Auth;
use Artisan;

abstract class BaseTest extends TestCase
{
    use LazilyRefreshDatabase;
}
