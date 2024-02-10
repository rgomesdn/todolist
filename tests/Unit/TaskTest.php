<?php

namespace Tests\Unit;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use App\Models\Task;
use App\Models\User;

class TaskTest extends TestCase
{
    use DatabaseMigrations;

    protected mixed $user;

    protected function setUp(): void
    {
        parent::setUp();

        // create users in the database
        User::factory(2)->create();
    }

    /** @test */
    public function authenticated_users_can_create_a_new_task()
    {
        // create a user and Auth this
        $this->actingAs(User::factory()->create());

        // make a task object
        $task = Task::factory()->make();

        // submits post request to create task endpoint
        $this->post('/tasks/store',$task->toArray());

        // gets stored in the database
        $this->assertEquals(1,Task::all()->count());
    }

    /** @test */
    public function unauthenticated_users_cannot_create_a_new_task()
    {
        // make a task object
        $task = Task::factory()->make();

        // submits post request to create task endpoint, redirect unauthorized user to login page
        $this->post('/tasks/store',$task->toArray())
            ->assertRedirect('/login');
    }

    /** @test */
    public function authenticated_users_can_update_a_self_task()
    {
        // create a user and Auth this
        $this->actingAs(User::factory()->create());

        // create a task and update by the user
        $task = Task::factory()->create(['user_id' => Auth::user()->id]);
        $task->title = "Updated Title";

        // user update the task
        $this->post('/tasks/update/'.$task->id, $task->toArray());

        // verify if task has updated in the database.
        $this->assertDatabaseHas('tasks',[
            'id'=> $task->id ,
            'title' => 'Updated Title'
        ]);
    }

    /** @test */
    public function authenticated_users_cannot_update_a_another_users_task()
    {
        // create a user and Auth this
        $this->actingAs(User::factory()->create());

        // create a task and update by another user
        $task = Task::factory()->create(['user_id' => 2]);
        $task->title = "Updated Title";

        // user update the task
        $this->post('/tasks/update/'.$task->id, $task->toArray());

        // get data after update
        $response = $this->get('/tasks/edit/'.$task->id);

        // verify if task has updated in the database.
        $response->assertStatus(403);
    }

    /** @test */
    public function unauthenticated_users_cannot_update_a_task()
    {
        // create a new task
        $task = Task::factory()->create();

        // submits post request to create task endpoint, redirect unauthorized user to login page
        $this->post('/tasks/update/'.$task->id,$task->toArray())
            ->assertRedirect('/login');
    }

    /** @test */
    public function authorized_user_can_delete_the_self_task(){
        // create a user and Auth this
        $this->actingAs(User::factory()->create());

        // create a task by the user
        $task = Task::factory()->create(['user_id' => Auth::user()->id]);

        // hit's the endpoint to delete the task
        $this->get('/tasks/delete/'.$task->id);

        // the task should be deleted from the database.
        $this->assertDatabaseMissing('tasks',['id' => $task->id]);
    }

    /** @test */
    public function authorized_user_cannot_delete_the_another_user_task(){
        // create a user and Auth this
        $this->actingAs(User::factory()->create());

        // create a task by another user
        $task = Task::factory()->create(['user_id' => 2]);

        // hit's the endpoint to delete the task
        $response = $this->get('/tasks/delete/'.$task->id);

        // verify if task has updated in the database.
        $response->assertStatus(403);
    }

    /** @test */
    public function unauthenticated_users_cannot_delete_a_task()
    {
        // make a task object
        $task = Task::factory()->create();

        // hits the delete task endpoint, redirect unauthorized user to login page
        $this->get('/tasks/delete/'.$task->id)
            ->assertRedirect('/login');
    }

    /** @test */
    public function a_user_can_read_all_the_tasks()
    {
        // create task in the database
        $task = Task::factory()->create();

        // when user visit the tasks page
        $response = $this->get('/tasks');

        // he should be able to read the task
        $response->assertSee($task->title);
    }

}
