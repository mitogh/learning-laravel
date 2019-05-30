<?php

namespace Tests\Integration\Http\Controllers\Auth;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
    public function ShouldDestroyAUserSessionOnLogOut()
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
