<?php

    namespace Test\Feature;

    use Illuminate\Foundation\Testing\DatabaseMigrations;
    use Tests\TestCase;

    class ThreadsTest extends TestCase
    {
        use DatabaseMigrations;

        public function setUp()
        {
            parent::setUp();
            $this->thread = factory('App\Thread')->create();
        }

        /**  @test */
        public function a_user_can_browse_all_threads()
        {

            $this->get('/threads')
                ->assertSee($this->thread->title);
        }

        /**  @test */

        public function a_user_can_browse_a_single_thread()
        {
            $this->get($this->thread->path())
                ->assertSee($this->thread->title);
        }

        /**  @test */
        public function a_user_can_read_replies_that_are_associated_with_a_thread()
        {
            $reply = create('App\Reply', ['thread_id' => $this->thread->id]);

            $this->get($this->thread->path())
                ->assertSee($reply->body);
        }

        /** @test */
        public function a_user_can_filter_threads_according_to_a_channel()
        {
            $channel=create('App\Channel');
            $threadWithChannel=create('App\Thread',['channel_id'=>$channel->id]);
            $threadWithoutChannel=create('App\Thread');

            $this->get('threads/'.$channel->slug)
                ->assertSee($threadWithChannel->title)
                ->assertDontSee($threadWithoutChannel->title);
        }

        /** @test */
        public function  a_user_can_filter_threads_by_any_username(){
            $this->signIn(create('App\User',['name'=>'CarlosGuevara']));
            $threadsByCarlos=create('App\Thread',['user_id'=>auth()->user()->id]);
            $threadsNotByCarlos=create('App\Thread');

            $this->get('threads?by=CarlosGuevara')
                ->assertSee($threadsByCarlos->title)
                ->assertDontSee($threadsNotByCarlos);



        }

    }


    ?>