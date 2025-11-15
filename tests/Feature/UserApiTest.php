<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UserApiTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
public function test_api_create_users()
{

    

    $admin = User::factory()->create([
        'role' => 'admin'
    ]);

    Sanctum::actingAs($admin);

    $data = [
        'nom' => 'moud',
        'prenom' => 'moud',
        'email' => 'moud3@gmail.com',
        'password' => '123456',
      
    ];

    $response = $this->postJson('api/users/create', $data);

    $response->assertStatus(201);

     $this->assertDatabaseHas('users', [
      'nom' => 'moud',
        'prenom' => 'moud',
        'email' => 'moud3@gmail.com'
     ]);
}


 public function test_api_list_users()
    {
      
        $admin = User::factory()->create([
              'role' => 'admin'
          ]);

        Sanctum::actingAs($admin);
        $response = $this->getJson('/api/users');

        $response->assertStatus(200)
                 ->assertJsonCount(2);
    }
 public function test_api_one_users()
    {
        // User::factory(3)->create();
        $admin = User::factory()->create([
              'role' => 'admin'
          ]);

        Sanctum::actingAs($admin);
        $response = $this->getJson("/api/users/show/{$admin->id}");

        $response->assertStatus(200)
                 ->assertJson(['id' => $admin->id]);
    }


    public function test_api_update_user()
    {
        
        $admin = User::factory()->create([
                    'role' => 'admin'
                ]);

        Sanctum::actingAs($admin);
        $update = ['nom' => 'Updated nom',
        'prenom' => 'teed',
        'email' => 'ddd@gmail.com',
        'role' => 'user',
        'password' => '123456',
      ];
        $id = $admin->id;
        $response = $this->putJson("/api/users/update/{$id}", $update);

        $response->assertStatus(200)
                 ->assertJson([
                  "user" => [
                    'nom' => 'Updated nom',
                    'prenom' => 'teed',
                    'email' => 'ddd@gmail.com',
                    'role' => 'user',
             ]
                 ]);

        $this->assertDatabaseHas('users', [
            'id' => $id,
            'nom' => 'Updated nom',
            'prenom' => 'teed',
            'email' => 'ddd@gmail.com',
            'role' => 'user',
        ]);
    }

     public function test_api_delete_user()
    {
          $admin = User::factory()->create([
                    'role' => 'admin'
                ]);

        Sanctum::actingAs($admin);

        $response = $this->deleteJson("/api/users/delete/{$admin->id}");

        $response->assertStatus(200)
                 ->assertJson(['message' => 'deleted']);

        $this->assertDatabaseMissing('users', ['id' => $admin->id]);
    }
}
