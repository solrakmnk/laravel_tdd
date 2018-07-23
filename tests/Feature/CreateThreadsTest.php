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
        $thread=make('App\Thread');
        $response=$this->post('/threads',$thread->toArray());

        $this->get($response->headers->get('location'))
            ->assertSee($thread->title);
    }

    /** @test */
    function a_thread_requires_a_title(){
        $this->publishThread(['title'=>null])
            ->assertSessionHasErrors('title');
    }

    /** @test */
    function a_thread_requires_a_body(){
        $this->publishThread(['body'=>null])
            ->assertSessionHasErrors('body');
    }
    /** @test */
    function a_thread_requires_a_valid_channel(){
        //$channel=create('App\Channel');
        //if channel with id exist it will fails

        $this->publishThread(['channel_id'=>1])
            ->assertSessionHasErrors('channel_id');
    }

    /** @test */
    public function publishThread($overrides=[]){
        $this->withExceptionHandling()->signIn();

        $thread=make('App\Thread',$overrides);

        return $this->post('/threads',$thread->toArray());
    }
}
