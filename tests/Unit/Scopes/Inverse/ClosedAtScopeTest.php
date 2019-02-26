<?php

/*
 * This file is part of Laravel Eloquent Flag.
 *
 * (c) Anton Komarev <a.komarev@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cog\Tests\Flag\Unit\Scopes\Inverse;

use Cog\Tests\Flag\Stubs\Models\Inverse\EntityWithClosedAt;
use Cog\Tests\Flag\TestCase;
use Illuminate\Support\Carbon;

class ClosedAtScopeTest extends TestCase
{
    /** @test */
    public function it_can_get_only_not_closed(): void
    {
        factory(EntityWithClosedAt::class, 2)->create([
            'closed_at' => Carbon::now()->subDay(),
        ]);
        factory(EntityWithClosedAt::class, 3)->create([
            'closed_at' => null,
        ]);

        $entities = EntityWithClosedAt::all();

        $this->assertCount(3, $entities);
    }

    /** @test */
    public function it_can_get_without_closed(): void
    {
        factory(EntityWithClosedAt::class, 2)->create([
            'closed_at' => Carbon::now()->subDay(),
        ]);
        factory(EntityWithClosedAt::class, 3)->create([
            'closed_at' => null,
        ]);

        $entities = EntityWithClosedAt::withoutClosed()->get();

        $this->assertCount(3, $entities);
    }

    /** @test */
    public function it_can_get_with_closed(): void
    {
        factory(EntityWithClosedAt::class, 2)->create([
            'closed_at' => Carbon::now()->subDay(),
        ]);
        factory(EntityWithClosedAt::class, 3)->create([
            'closed_at' => null,
        ]);

        $entities = EntityWithClosedAt::withClosed()->get();

        $this->assertCount(5, $entities);
    }

    /** @test */
    public function it_can_get_only_closed(): void
    {
        factory(EntityWithClosedAt::class, 2)->create([
            'closed_at' => Carbon::now()->subDay(),
        ]);
        factory(EntityWithClosedAt::class, 3)->create([
            'closed_at' => null,
        ]);

        $entities = EntityWithClosedAt::onlyClosed()->get();

        $this->assertCount(2, $entities);
    }

    /** @test */
    public function it_can_open_model(): void
    {
        $model = factory(EntityWithClosedAt::class)->create([
            'closed_at' => Carbon::now()->subDay(),
        ]);

        EntityWithClosedAt::where('id', $model->id)->open();

        $model = EntityWithClosedAt::where('id', $model->id)->first();

        $this->assertNull($model->closed_at);
    }

    /** @test */
    public function it_can_close_model(): void
    {
        $model = factory(EntityWithClosedAt::class)->create([
            'closed_at' => null,
        ]);

        EntityWithClosedAt::where('id', $model->id)->close();

        $model = EntityWithClosedAt::withClosed()->where('id', $model->id)->first();

        $this->assertNotNull($model->closed_at);
    }
}
