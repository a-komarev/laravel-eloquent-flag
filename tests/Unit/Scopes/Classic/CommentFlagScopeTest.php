<?php

/*
 * This file is part of Laravel Eloquent Flag.
 *
 * (c) Sivan Wolberg <sivan@wolberg.pro>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cog\Tests\Flag\Unit\Scopes\Classic;

use Cog\Tests\Flag\Stubs\Models\Classic\EntityWithCommentFlag;
use Cog\Tests\Flag\Stubs\Models\Classic\EntityWithCommentFlagApplied;
use Cog\Tests\Flag\Stubs\Models\Classic\EntityWithCommentFlagUnapplied;
use Cog\Tests\Flag\TestCase;

final class CommentFlagScopeTest extends TestCase
{
    /** @test */
    public function it_get_without_global_scope_default(): void
    {
        factory(EntityWithCommentFlag::class, 3)->create([
            'is_comment' => true,
        ]);
        factory(EntityWithCommentFlag::class, 2)->create([
            'is_comment' => false,
        ]);

        $entities = EntityWithCommentFlag::all();

        $this->assertCount(5, $entities);
    }

    /** @test */
    public function it_can_get_without_not_comment(): void
    {
        factory(EntityWithCommentFlag::class, 3)->create([
            'is_comment' => true,
        ]);
        factory(EntityWithCommentFlag::class, 2)->create([
            'is_comment' => false,
        ]);

        $entities = EntityWithCommentFlag::withoutNotcomment()->get();

        $this->assertCount(3, $entities);
    }

    /** @test */
    public function it_can_get_with_not_comment(): void
    {
        factory(EntityWithCommentFlag::class, 3)->create([
            'is_comment' => true,
        ]);
        factory(EntityWithCommentFlag::class, 2)->create([
            'is_comment' => false,
        ]);

        $entities = EntityWithCommentFlag::withNotcomment()->get();

        $this->assertCount(5, $entities);
    }

    /** @test */
    public function it_can_get_only_not_comment(): void
    {
        factory(EntityWithCommentFlag::class, 3)->create([
            'is_comment' => true,
        ]);
        factory(EntityWithCommentFlag::class, 2)->create([
            'is_comment' => false,
        ]);

        $entities = EntityWithCommentFlag::onlyNotcomment()->get();

        $this->assertCount(2, $entities);
    }

    /** @test */
    public function it_can_approve_model(): void
    {
        $model = factory(EntityWithCommentFlag::class)->create([
            'is_comment' => false,
        ]);

        EntityWithCommentFlag::where('id', $model->id)->approve();

        $model = EntityWithCommentFlag::where('id', $model->id)->first();

        $this->assertTrue($model->is_comment);
    }

    /** @test */
    public function it_can_undo_comment_model(): void
    {
        $model = factory(EntityWithcommentFlag::class)->create([
            'is_comment' => true,
        ]);

        EntityWithcommentFlag::where('id', $model->id)->undoApprove();

        $model = EntityWithcommentFlag::withNotcomment()->where('id', $model->id)->first();

        $this->assertFalse($model->is_comment);
    }

    /** @test */
    public function it_can_skip_apply(): void
    {
        factory(EntityWithCommentFlag::class, 3)->create([
            'is_comment' => true,
        ]);
        factory(EntityWithCommentFlag::class, 2)->create([
            'is_comment' => false,
        ]);

        $entities = EntityWithCommentFlagUnapplied::all();

        $this->assertCount(5, $entities);
    }

    /** @test */
    public function it_can_auto_apply(): void
    {
        factory(EntityWithCommentFlag::class, 3)->create([
            'is_comment' => true,
        ]);
        factory(EntityWithCommentFlag::class, 2)->create([
            'is_comment' => false,
        ]);

        $entities = EntityWithCommentFlagApplied::all();

        $this->assertCount(3, $entities);
    }
}