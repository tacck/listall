<?php

namespace Tests\Feature;

use Illuminate\Http\Response;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiBookmarkControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testApiCommit_成功()
    {
        // ユーザーを作成
        $user = factory(\App\User::class)->create();

        $data = [
            'username' => $user->htn_name,
            'title' => str_random(255),
            'url' => str_random(255),
            'permalink' => str_random(255),
            'comment' => str_random(255),
            'is_private' => '1',
            'timestamp' => (new \DateTime())->format(DATE_W3C),
            'status' => 'add',
            'key' => 'TEST_KEY',
        ];

        $response = $this->post('/api/commit', $data);
        $response->assertStatus(Response::HTTP_CREATED);
    }

    public function testApiCommit_失敗_異なるキー()
    {
        // ユーザーを作成
        $user = factory(\App\User::class)->create();

        $data = [
            'username' => $user->htn_name,
            'title' => str_random(255),
            'url' => str_random(255),
            'permalink' => str_random(255),
            'comment' => str_random(255),
            'is_private' => '1',
            'timestamp' => (new \DateTime())->format(DATE_W3C),
            'status' => 'add',
            'key' => str_random(255),
        ];

        $response = $this->post('/api/commit', $data);
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function testApiCommit_失敗_存在しないユーザー()
    {
        // ユーザーを作成
        $user = factory(\App\User::class)->create();

        $data = [
            'username' => $user->name,
            'title' => str_random(255),
            'url' => str_random(255),
            'permalink' => str_random(255),
            'comment' => str_random(255),
            'is_private' => '1',
            'timestamp' => (new \DateTime())->format(DATE_W3C),
            'status' => 'add',
            'key' => 'TEST_KEY',
        ];

        $response = $this->post('/api/commit', $data);
        $response->assertStatus(Response::HTTP_INTERNAL_SERVER_ERROR);
    }

}
