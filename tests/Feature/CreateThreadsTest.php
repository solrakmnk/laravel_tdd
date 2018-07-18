<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CreateThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function guest_cannot_see_the_create_thread_form(){
        $this->withExceptionHandling()
            ->get('/threads/create')
            ->assertRedirect('/login');
    }

    /** @test */
    function guest_may_not_create_threads(){
        $this->expectException('Illuminate\Auth\AuthenticationException');
        $thread=make('App\Thread');
        $this->post('/threads',$thread->toArray());
    }

    /** @test */
    function an_authenticated_user_can_create_new_forum_threads(){
        //$this->actingAs(create('App\User'));
        $this->signIn();
        $thread=make('App\Thread',[]);
        $this->post('/threads',$thread->toArray());
        $this->get($thread->path())
            ->assertSee($thread->title);
    }
}
