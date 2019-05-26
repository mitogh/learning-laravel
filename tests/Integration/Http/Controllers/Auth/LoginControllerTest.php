<?php

namespace Tests\Integration\Http\Controllers\Auth;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * It should destroy a user session on log out
     *
     * @test
     */
    public function should_destroy_a_user_session_on_log_out()
    {
        $user = factory( User::class )->create();
        $this->actingAs( $user );

        $this->assertTrue( Auth::check() );
        $this->assertEquals( $user->id, Auth::id() );

        $response = $this->delete( '/logout' );

        $this->assertFalse( Auth::check() );
        $response->assertRedirect( '/' );
    }
}
