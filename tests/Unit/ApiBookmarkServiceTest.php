<?php

namespace Tests\Unit;

use App\Http\Service\ApiBookmarkService;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiBookmarkServiceTest extends TestCase
{
    use RefreshDatabase;

    public function testIsCollectKey_成功()
    {
        $this->assertTrue(ApiBookmarkService::isCollectKey("TEST_KEY"));
    }

    public function testIsCollectKey_失敗_引数_異なるキー()
    {
        $this->assertFalse(ApiBookmarkService::isCollectKey("TEST_KEY_FALSE"));
    }

    public function testIsCollectKey_失敗_引数_空文字()
    {
        $this->assertFalse(ApiBookmarkService::isCollectKey(""));
    }

    public function testIsCollectKey_失敗_引数_null()
    {
        $this->assertFalse(ApiBookmarkService::isCollectKey(null));
    }

    public function testCommitBookmark_成功_追加()
    {
        $user = factory(\App\User::class)->create();

        $expectedName = $user->name;
        $expectedTitle = str_random(255);
        $expectedUrl = str_random(255);
        $expectedPermalink = str_random(255);
        $expectedComment = str_random(255);
        $expectedIsPrivate = random_int(0, 1);
        $expectedTimestamp = (new \DateTime())->format(DATE_W3C);
        $expectedStatus = 'add';

        $actual = ApiBookmarkService::commitBookmark(
            $expectedName,
            $expectedTitle,
            $expectedUrl,
            $expectedPermalink,
            $expectedComment,
            $expectedIsPrivate,
            $expectedTimestamp,
            $expectedStatus
        );

        $this->assertTrue($actual);
        $this->assertDatabaseHas('bookmarks', [
            'username' => $expectedName,
            'title' => $expectedTitle,
            'url' => $expectedUrl,
            'permalink' => $expectedPermalink,
            'comment' => $expectedComment,
            'is_private' => $expectedIsPrivate,
            'htn_add_datetime' => $expectedTimestamp,
            'is_read_for_later' => preg_match('/' . env('HATENA_BOOKMARK_READ_FOR_LATER_TAG') . '/', $expectedComment),
            'htn_add_date' => substr($expectedTimestamp, 0, 10),
            'user_id' => $user->id,
        ]);
    }

    public function testCommitBookmark_成功_追加_あとで読む()
    {
        $user = factory(\App\User::class)->create();

        $expectedName = $user->name;
        $expectedTitle = str_random(255);
        $expectedUrl = str_random(255);
        $expectedPermalink = str_random(255);
        $expectedComment = str_random(100)
            . str_replace('\\', '', env('HATENA_BOOKMARK_READ_FOR_LATER_TAG'))
            . str_random(100);
        $expectedIsPrivate = random_int(0, 1);
        $expectedTimestamp = (new \DateTime())->format(DATE_W3C);
        $expectedStatus = 'add';

        $actual = ApiBookmarkService::commitBookmark(
            $expectedName,
            $expectedTitle,
            $expectedUrl,
            $expectedPermalink,
            $expectedComment,
            $expectedIsPrivate,
            $expectedTimestamp,
            $expectedStatus
        );

        $this->assertTrue($actual);
        $this->assertDatabaseHas('bookmarks', [
            'username' => $expectedName,
            'title' => $expectedTitle,
            'url' => $expectedUrl,
            'permalink' => $expectedPermalink,
            'comment' => $expectedComment,
            'is_private' => $expectedIsPrivate,
            'htn_add_datetime' => $expectedTimestamp,
            'is_read_for_later' => 1,
            'htn_add_date' => substr($expectedTimestamp, 0, 10),
            'user_id' => $user->id,
        ]);
    }

    public function testCommitBookmark_成功_更新()
    {
        $user = factory(\App\User::class)->create();

        // 追加
        $expectedName = $user->name;
        $expectedTitle = str_random(255);
        $expectedUrl = str_random(255);
        $expectedPermalink = str_random(255);
        $expectedComment = str_random(255);
        $expectedIsPrivate = random_int(0, 1);
        $expectedTimestamp = (new \DateTime())->format(DATE_W3C);
        $expectedStatus = 'add';

        $actual = ApiBookmarkService::commitBookmark(
            $expectedName,
            $expectedTitle,
            $expectedUrl,
            $expectedPermalink,
            $expectedComment,
            $expectedIsPrivate,
            $expectedTimestamp,
            $expectedStatus
        );

        $this->assertTrue($actual);

        $this->assertDatabaseHas('bookmarks', [
            'username' => $expectedName,
            'title' => $expectedTitle,
            'url' => $expectedUrl,
            'permalink' => $expectedPermalink,
            'comment' => $expectedComment,
            'is_private' => $expectedIsPrivate,
            'htn_add_datetime' => $expectedTimestamp,
            'is_read_for_later' => preg_match('/' . env('HATENA_BOOKMARK_READ_FOR_LATER_TAG') . '/', $expectedComment),
            'htn_add_date' => substr($expectedTimestamp, 0, 10),
            'user_id' => $user->id,
        ]);

        // 更新
        // ユーザー名(id)とpermalinkがでユニーク判定するので、この二つは更新しない。
        //        $expectedName = $user->name;
        $expectedTitle = str_random(255);
        $expectedUrl = str_random(255);
        //        $expectedPermalink = str_random(255); permalink
        $expectedComment = str_random(255);
        $expectedIsPrivate = random_int(0, 1);
        $expectedTimestamp = (new \DateTime())->format(DATE_W3C);
        $expectedStatus = 'updated';

        $actual = ApiBookmarkService::commitBookmark(
            $expectedName,
            $expectedTitle,
            $expectedUrl,
            $expectedPermalink,
            $expectedComment,
            $expectedIsPrivate,
            $expectedTimestamp,
            $expectedStatus
        );

        $this->assertTrue($actual);
        $this->assertDatabaseHas('bookmarks', [
            'username' => $expectedName,
            'title' => $expectedTitle,
            'url' => $expectedUrl,
            'permalink' => $expectedPermalink,
            'comment' => $expectedComment,
            'is_private' => $expectedIsPrivate,
            'htn_add_datetime' => $expectedTimestamp,
            'is_read_for_later' => preg_match('/' . env('HATENA_BOOKMARK_READ_FOR_LATER_TAG') . '/', $expectedComment),
            'htn_add_date' => substr($expectedTimestamp, 0, 10),
            'user_id' => $user->id,
        ]);
    }

    public function testCommitBookmark_失敗_追加_存在しないユーザー()
    {
        $user = factory(\App\User::class)->create();

        $expectedName = substr($user->name, 0, 1);
        $expectedTitle = str_random(255);
        $expectedUrl = str_random(255);
        $expectedPermalink = str_random(255);
        $expectedComment = str_random(255);
        $expectedIsPrivate = random_int(0, 1);
        $expectedTimestamp = (new \DateTime())->format(DATE_W3C);
        $expectedStatus = 'add';

        $actual = ApiBookmarkService::commitBookmark(
            $expectedName,
            $expectedTitle,
            $expectedUrl,
            $expectedPermalink,
            $expectedComment,
            $expectedIsPrivate,
            $expectedTimestamp,
            $expectedStatus
        );

        $this->assertFalse($actual);
    }

    public function testToArray()
    {
        $user = factory(\App\User::class)->create();

        $expectedName = $user->name;
        $expectedTitle = str_random(255);
        $expectedUrl = str_random(255);
        $expectedPermalink = str_random(255);
        $expectedComment = str_random(255);
        $expectedIsPrivate = random_int(0, 1);
        $expectedTimestamp = Carbon::now();

        $actual = ApiBookmarkService::toArray($expectedName,
            $expectedTitle,
            $expectedUrl,
            $expectedPermalink,
            $expectedComment,
            $expectedIsPrivate,
            $expectedTimestamp->format(DATE_W3C)
        );

        $this->assertArrayHasKey('username', $actual);
        $this->assertEquals($expectedName, $actual['username']);

        $this->assertArrayHasKey('title', $actual);
        $this->assertEquals($expectedTitle, $actual['title']);

        $this->assertArrayHasKey('url', $actual);
        $this->assertEquals($expectedUrl, $actual['url']);

        $this->assertArrayHasKey('permalink', $actual);
        $this->assertEquals($expectedPermalink, $actual['permalink']);

        $this->assertArrayHasKey('comment', $actual);
        $this->assertEquals($expectedComment, $actual['comment']);

        $this->assertArrayHasKey('is_private', $actual);
        $this->assertEquals($expectedIsPrivate, $actual['is_private']);

        $this->assertArrayHasKey('is_read_for_later', $actual);
        $this->assertEquals(0, $actual['is_read_for_later']);

        $this->assertArrayHasKey('htn_add_datetime', $actual);
        $this->assertEquals($expectedTimestamp->format("Y-m-d H:i:s"), $actual['htn_add_datetime']);

        $this->assertArrayHasKey('htn_add_date', $actual);
        $this->assertEquals($expectedTimestamp->format("Y-m-d"), $actual['htn_add_date']);

        $this->assertArrayHasKey('user_id', $actual);
        $this->assertEquals($user->id, $actual['user_id']);

        $this->assertArrayHasKey('created_at', $actual);
        $this->assertArrayHasKey('updated_at', $actual);
    }
}
