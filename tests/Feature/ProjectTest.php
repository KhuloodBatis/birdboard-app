<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**@test  */
    public function test_a_user_can_a_project_successfully()
    {
        $this->withoutExceptionHandling();
        $attriutes = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph
        ];

        $this->post('/projects', $attriutes)->assertRedirect('/projects');

        // $this->assertDatabaseHas('projects', $attriutes);
        // $this->get('/projects')->assertSee($attriutes['title']);
    }

    /**@test*/
    // public function test_a_user_can_see_project_title_successfully()
    // {
    //     $this->withoutExceptionHandling();
    //     $attriutes = [
    //         'title' => $this->faker->sentence,
    //         'description' => $this->faker->paragraph
    //     ];
    //     $this->get('/projects')->assertSee($attriutes['title']);
    // }
}
