<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CreateThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function guest_cannot_see_the_create_threads(){
        $this->withExceptionHandling();

        $this->get('/threads/create')
            ->assertRedirect('/login');
        $this->post('/threads')
            ->assertRedirect('/login');
    }

    /** @test */
    function an_authenticated_user_can_create_new_forum_threads(){
        //$this->actingAs(create('App\User'));
        $this->signIn();
        $thread=create('App\Thread');
        $this->post('/threads',$thread->toArray());
        $this->get($thread->path())
            ->assertSee($thread->title);
    }
}
