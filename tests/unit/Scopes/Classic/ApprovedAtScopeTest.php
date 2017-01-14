<?php

/*
 * This file is part of Laravel Eloquent Flag.
 *
 * (c) Anton Komarev <a.komarev@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cog\Flag\Tests\Unit\Scopes\Classic;

use Carbon\Carbon;
use Cog\Flag\Tests\Stubs\Models\Classic\EntityWithApprovedAt;
use Cog\Flag\Tests\TestCase;

/**
 * Class ApprovedAtScopeTest.
 *
 * @package Cog\Flag\Tests\Unit\Scopes\Classic
 */
class ApprovedAtScopeTest extends TestCase
{
    /** @test */
    public function it_can_get_only_approved()
    {
        factory(EntityWithApprovedAt::class, 3)->create([
            'approved_at' => Carbon::now()->subDay(),
        ]);
        factory(EntityWithApprovedAt::class, 2)->create([
            'approved_at' => null,
        ]);

        $entities = EntityWithApprovedAt::all();

        $this->assertCount(3, $entities);
    }

    /** @test */
    public function it_can_get_without_disapproved()
    {
        factory(EntityWithApprovedAt::class, 3)->create([
            'approved_at' => Carbon::now()->subDay(),
        ]);
        factory(EntityWithApprovedAt::class, 2)->create([
            'approved_at' => null,
        ]);

        $entities = EntityWithApprovedAt::withoutDisapproved()->get();

        $this->assertCount(3, $entities);
    }

    /** @test */
    public function it_can_get_with_disapproved()
    {
        factory(EntityWithApprovedAt::class, 3)->create([
            'approved_at' => Carbon::now()->subDay(),
        ]);
        factory(EntityWithApprovedAt::class, 2)->create([
            'approved_at' => null,
        ]);

        $entities = EntityWithApprovedAt::withDisapproved()->get();

        $this->assertCount(5, $entities);
    }

    /** @test */
    public function it_can_get_only_disapproved()
    {
        factory(EntityWithApprovedAt::class, 3)->create([
            'approved_at' => Carbon::now()->subDay(),
        ]);
        factory(EntityWithApprovedAt::class, 2)->create([
            'approved_at' => null,
        ]);

        $entities = EntityWithApprovedAt::onlyDisapproved()->get();

        $this->assertCount(2, $entities);
    }

    /** @test */
    public function it_can_approve_model()
    {
        $model = factory(EntityWithApprovedAt::class)->create([
            'approved_at' => null,
        ]);

        EntityWithApprovedAt::where('id', $model->id)->approve();

        $model = EntityWithApprovedAt::where('id', $model->id)->first();

        $this->assertNotNull($model->approved_at);
    }

    /** @test */
    public function it_can_disapprove_model()
    {
        $model = factory(EntityWithApprovedAt::class)->create([
            'approved_at' => Carbon::now()->subDay(),
        ]);

        EntityWithApprovedAt::where('id', $model->id)->disapprove();

        $model = EntityWithApprovedAt::withDisapproved()->where('id', $model->id)->first();

        $this->assertNull($model->approved_at);
    }
}
