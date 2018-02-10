<?php

namespace Tests\Unit;

use App\Http\Service\BookmarkService;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookmarkServiceTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory(\App\User::class)->create();
        // モックでユーザー固定
        Auth::shouldReceive('id')
            ->andReturn($this->user->id);

        factory(\App\Bookmark::class, 10)->create([
            'username' => $this->user->name,
            'user_id' => $this->user->id,
            'htn_add_date' => '2018-01-01',
            'htn_add_datetime' => '2018-01-01 00:00:00'
        ]);
        factory(\App\Bookmark::class, 10)->create([
            'username' => $this->user->name,
            'user_id' => $this->user->id,
            'htn_add_date' => '2018-01-10',
            'htn_add_datetime' => '2018-01-10 00:00:00'
        ]);
    }

    /**
     * 日別件数一覧のページネーション対応テスト
     */
    public function testGetCountEachDaysWithoutReadForLater_成功_ページ内アイテム数制限範囲内()
    {
        $bookmarks = BookmarkService::getCountEachDaysWithoutReadForLater("2018-01-01", "2018-01-10", 1, 10);
        $this->assertEquals(2, count($bookmarks));
    }

    /**
     * 日別件数一覧のページネーション対応テスト
     */
    public function testGetCountEachDaysWithoutReadForLater_成功_ページ内アイテム数制限有効()
    {
        $bookmarks = BookmarkService::getCountEachDaysWithoutReadForLater("2018-01-01", "2018-01-10", 1, 1);
        $this->assertEquals(1, count($bookmarks));

        $items = $bookmarks->toArray()['data'];
        $item = $items[0];
        $this->assertEquals("2018-01-10", $item['date']);
        $this->assertEquals(10, $item['count']);
    }


    /**
     * 日別件数一覧のページネーション対応テスト
     *
     * @expectedException \InvalidArgumentException
     */
    public function testGetCountEachDaysWithoutReadForLater_失敗_制限チェック_ページ負数()
    {
        $bookmarks = BookmarkService::getCountEachDaysWithoutReadForLater("2018-01-01", "2018-01-10", -1, 10);
    }

    /**
     * 日別件数一覧のページネーション対応テスト
     *
     * @expectedException \InvalidArgumentException
     */
    public function testGetCountEachDaysWithoutReadForLater_失敗_制限チェック_サイズ負数()
    {
        $bookmarks = BookmarkService::getCountEachDaysWithoutReadForLater("2018-01-01", "2018-01-10", 1, -1);
    }

    /**
     * 日別件数一覧のページネーション対応テスト
     */
    public function testGetCountEachDaysWithoutReadForLater_失敗_制限チェック_ページ範囲外()
    {
        $bookmarks = BookmarkService::getCountEachDaysWithoutReadForLater("2018-01-01", "2018-01-10", 2, 10);

        $this->assertEquals(0, count($bookmarks));
    }
}
