<?php

namespace Tests\Unit;

use App\Bookmark;
use App\Http\Service\ApiBookmarkService;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookmarkTest extends TestCase
{
    use RefreshDatabase;

    public function testBlkInsert_成功_trancate有り()
    {
        $user = factory(\App\User::class)->create();

        $expectedName = $user->name;
        $expectedTitle = str_random(255);
        $expectedUrl = str_random(255);
        $expectedPermalink = str_random(255);
        $expectedComment = str_random(255);
        $expectedIsPrivate = random_int(0, 1);
        $expectedTimestamp = Carbon::now()->format(DATE_W3C);

        $items = [
            ApiBookmarkService::toArray(
                $expectedName,
                $expectedTitle,
                $expectedUrl,
                $expectedPermalink,
                $expectedComment,
                $expectedIsPrivate,
                $expectedTimestamp
            )
        ];

        $actual = Bookmark::blkInsert($items, true);

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

    public function testBlkInsert_成功_trancate無し_新規追加()
    {
        $user1 = factory(\App\User::class)->create();

        $expectedName1 = $user1->name;
        $expectedTitle1 = str_random(255);
        $expectedUrl1 = str_random(255);
        $expectedPermalink1 = str_random(255);
        $expectedComment1 = str_random(255);
        $expectedIsPrivate1 = random_int(0, 1);
        $expectedTimestamp1 = Carbon::now()->format(DATE_W3C);

        $items = [
            ApiBookmarkService::toArray(
                $expectedName1,
                $expectedTitle1,
                $expectedUrl1,
                $expectedPermalink1,
                $expectedComment1,
                $expectedIsPrivate1,
                $expectedTimestamp1
            )
        ];

        $actual = Bookmark::blkInsert($items, true);

        $this->assertTrue($actual);
        $this->assertDatabaseHas('bookmarks', [
            'username' => $expectedName1,
            'title' => $expectedTitle1,
            'url' => $expectedUrl1,
            'permalink' => $expectedPermalink1,
            'comment' => $expectedComment1,
            'is_private' => $expectedIsPrivate1,
            'htn_add_datetime' => $expectedTimestamp1,
            'is_read_for_later' => preg_match('/' . env('HATENA_BOOKMARK_READ_FOR_LATER_TAG') . '/', $expectedComment1),
            'htn_add_date' => substr($expectedTimestamp1, 0, 10),
            'user_id' => $user1->id,
        ]);


        $user2 = factory(\App\User::class)->create();

        $expectedName2 = $user2->name;
        $expectedTitle2 = str_random(255);
        $expectedUrl2 = str_random(255);
        $expectedPermalink2 = str_random(255);
        $expectedComment2 = str_random(255);
        $expectedIsPrivate2 = random_int(0, 1);
        $expectedTimestamp2 = Carbon::now()->format(DATE_W3C);

        $items = [
            ApiBookmarkService::toArray(
                $expectedName2,
                $expectedTitle2,
                $expectedUrl2,
                $expectedPermalink2,
                $expectedComment2,
                $expectedIsPrivate2,
                $expectedTimestamp2
            )
        ];

        $actual = Bookmark::blkInsert($items, false);

        $this->assertTrue($actual);
        $this->assertDatabaseHas('bookmarks', [
            'username' => $expectedName1,
            'title' => $expectedTitle1,
            'url' => $expectedUrl1,
            'permalink' => $expectedPermalink1,
            'comment' => $expectedComment1,
            'is_private' => $expectedIsPrivate1,
            'htn_add_datetime' => $expectedTimestamp1,
            'is_read_for_later' => preg_match('/' . env('HATENA_BOOKMARK_READ_FOR_LATER_TAG') . '/', $expectedComment1),
            'htn_add_date' => substr($expectedTimestamp1, 0, 10),
            'user_id' => $user1->id,
        ]);
        $this->assertDatabaseHas('bookmarks', [
            'username' => $expectedName2,
            'title' => $expectedTitle2,
            'url' => $expectedUrl2,
            'permalink' => $expectedPermalink2,
            'comment' => $expectedComment2,
            'is_private' => $expectedIsPrivate2,
            'htn_add_datetime' => $expectedTimestamp2,
            'is_read_for_later' => preg_match('/' . env('HATENA_BOOKMARK_READ_FOR_LATER_TAG') . '/', $expectedComment2),
            'htn_add_date' => substr($expectedTimestamp2, 0, 10),
            'user_id' => $user2->id,
        ]);
    }

    /**
     * @expectedException Illuminate\Database\QueryException
     */
    public function testBlkInsert_失敗_trancate無し_衝突()
    {
        $user1 = factory(\App\User::class)->create();

        $expectedName1 = $user1->name;
        $expectedTitle1 = str_random(255);
        $expectedUrl1 = str_random(255);
        $expectedPermalink1 = str_random(255);
        $expectedComment1 = str_random(255);
        $expectedIsPrivate1 = random_int(0, 1);
        $expectedTimestamp1 = Carbon::now()->format(DATE_W3C);

        $items = [
            ApiBookmarkService::toArray(
                $expectedName1,
                $expectedTitle1,
                $expectedUrl1,
                $expectedPermalink1,
                $expectedComment1,
                $expectedIsPrivate1,
                $expectedTimestamp1
            )
        ];

        $actual = Bookmark::blkInsert($items, true);

        $this->assertTrue($actual);
        $this->assertDatabaseHas('bookmarks', [
            'username' => $expectedName1,
            'title' => $expectedTitle1,
            'url' => $expectedUrl1,
            'permalink' => $expectedPermalink1,
            'comment' => $expectedComment1,
            'is_private' => $expectedIsPrivate1,
            'htn_add_datetime' => $expectedTimestamp1,
            'is_read_for_later' => preg_match('/' . env('HATENA_BOOKMARK_READ_FOR_LATER_TAG') . '/', $expectedComment1),
            'htn_add_date' => substr($expectedTimestamp1, 0, 10),
            'user_id' => $user1->id,
        ]);


        $user2 = factory(\App\User::class)->create();

        $expectedName2 = $user2->name;
        $expectedTitle2 = str_random(255);
        $expectedUrl2 = str_random(255);
        $expectedPermalink2 = str_random(255);
        $expectedComment2 = str_random(255);
        $expectedIsPrivate2 = random_int(0, 1);
        $expectedTimestamp2 = Carbon::now()->format(DATE_W3C);

        $items = [
            ApiBookmarkService::toArray(
                $expectedName1,
                $expectedTitle1,
                $expectedUrl1,
                $expectedPermalink1,
                $expectedComment1,
                $expectedIsPrivate1,
                $expectedTimestamp1
            ),
            ApiBookmarkService::toArray(
                $expectedName2,
                $expectedTitle2,
                $expectedUrl2,
                $expectedPermalink2,
                $expectedComment2,
                $expectedIsPrivate2,
                $expectedTimestamp2
            )
        ];

        // 同一レコードが存在するので例外発生
        $actual = Bookmark::blkInsert($items, false);
    }
}
