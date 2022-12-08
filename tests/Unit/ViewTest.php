<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

class ViewTest extends TestCase
{

    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_all_routes_working()
    {
        $user = new User();
        $this->be($user);

        $this->call('GET', route('homepage'))->assertOk();
        $this->call('GET', route('members'))->assertOk();
        $this->call('GET', route('admin_panel'))->assertOk();
    }
}
