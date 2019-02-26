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

namespace Cog\Tests\Flag\Unit\Scopes\Classic;

use Cog\Tests\Flag\Stubs\Models\Classic\EntityWithAcceptedAt;
use Cog\Tests\Flag\TestCase;
use Illuminate\Support\Carbon;

class AcceptedAtScopeTest extends TestCase
{
    /** @test */
    public function it_can_get_only_accepted(): void
    {
        factory(EntityWithAcceptedAt::class, 3)->create([
            'accepted_at' => Carbon::now()->subDay(),
        ]);
        factory(EntityWithAcceptedAt::class, 2)->create([
            'accepted_at' => null,
        ]);

        $entities = EntityWithAcceptedAt::all();

        $this->assertCount(3, $entities);
    }

    /** @test */
    public function it_can_get_without_rejected(): void
    {
        factory(EntityWithAcceptedAt::class, 3)->create([
            'accepted_at' => Carbon::now()->subDay(),
        ]);
        factory(EntityWithAcceptedAt::class, 2)->create([
            'accepted_at' => null,
        ]);

        $entities = EntityWithAcceptedAt::withoutRejected()->get();

        $this->assertCount(3, $entities);
    }

    /** @test */
    public function it_can_get_with_rejected(): void
    {
        factory(EntityWithAcceptedAt::class, 3)->create([
            'accepted_at' => Carbon::now()->subDay(),
        ]);
        factory(EntityWithAcceptedAt::class, 2)->create([
            'accepted_at' => null,
        ]);

        $entities = EntityWithAcceptedAt::withRejected()->get();

        $this->assertCount(5, $entities);
    }

    /** @test */
    public function it_can_get_only_rejected(): void
    {
        factory(EntityWithAcceptedAt::class, 3)->create([
            'accepted_at' => Carbon::now()->subDay(),
        ]);
        factory(EntityWithAcceptedAt::class, 2)->create([
            'accepted_at' => null,
        ]);

        $entities = EntityWithAcceptedAt::onlyRejected()->get();

        $this->assertCount(2, $entities);
    }

    /** @test */
    public function it_can_accept_model(): void
    {
        $model = factory(EntityWithAcceptedAt::class)->create([
            'accepted_at' => null,
        ]);

        EntityWithAcceptedAt::where('id', $model->id)->accept();

        $model = EntityWithAcceptedAt::where('id', $model->id)->first();

        $this->assertNotNull($model->accepted_at);
    }

    /** @test */
    public function it_can_reject_model(): void
    {
        $model = factory(EntityWithAcceptedAt::class)->create([
            'accepted_at' => Carbon::now()->subDay(),
        ]);

        EntityWithAcceptedAt::where('id', $model->id)->reject();

        $model = EntityWithAcceptedAt::withRejected()->where('id', $model->id)->first();

        $this->assertNull($model->accepted_at);
    }
}
