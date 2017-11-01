<?php

/*
 * This file is part of Laravel Eloquent Flag.
 *
 * (c) Anton Komarev <a.komarev@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cog\Tests\Flag\Unit\Scopes\Classic;

use Cog\Tests\Flag\Stubs\Models\Classic\EntityWithInvitedFlag;
use Cog\Tests\Flag\Stubs\Models\Classic\EntityWithInvitedFlagUnapplied;
use Cog\Tests\Flag\TestCase;

/**
 * Class InvitedFlagScopeTest.
 *
 * @package Cog\Tests\Flag\Unit\Scopes\Classic
 */
class InvitedFlagScopeTest extends TestCase
{
    /** @test */
    public function it_can_get_only_invited()
    {
        factory(EntityWithInvitedFlag::class, 3)->create([
            'is_invited' => true,
        ]);
        factory(EntityWithInvitedFlag::class, 2)->create([
            'is_invited' => false,
        ]);

        $entities = EntityWithInvitedFlag::all();

        $this->assertCount(3, $entities);
    }

    /** @test */
    public function it_can_get_without_uninvited()
    {
        factory(EntityWithInvitedFlag::class, 3)->create([
            'is_invited' => true,
        ]);
        factory(EntityWithInvitedFlag::class, 2)->create([
            'is_invited' => false,
        ]);

        $entities = EntityWithInvitedFlag::withoutUninvited()->get();

        $this->assertCount(3, $entities);
    }

    /** @test */
    public function it_can_get_with_uninvited()
    {
        factory(EntityWithInvitedFlag::class, 3)->create([
            'is_invited' => true,
        ]);
        factory(EntityWithInvitedFlag::class, 2)->create([
            'is_invited' => false,
        ]);

        $entities = EntityWithInvitedFlag::withUninvited()->get();

        $this->assertCount(5, $entities);
    }

    /** @test */
    public function it_can_get_only_uninvited()
    {
        factory(EntityWithInvitedFlag::class, 3)->create([
            'is_invited' => true,
        ]);
        factory(EntityWithInvitedFlag::class, 2)->create([
            'is_invited' => false,
        ]);

        $entities = EntityWithInvitedFlag::onlyUninvited()->get();

        $this->assertCount(2, $entities);
    }

    /** @test */
    public function it_can_invite_model()
    {
        $model = factory(EntityWithInvitedFlag::class)->create([
            'is_invited' => false,
        ]);

        EntityWithInvitedFlag::where('id', $model->id)->invite();

        $model = EntityWithInvitedFlag::where('id', $model->id)->first();

        $this->assertTrue($model->is_invited);
    }

    /** @test */
    public function it_can_uninvite_model()
    {
        $model = factory(EntityWithInvitedFlag::class)->create([
            'is_invited' => true,
        ]);

        EntityWithInvitedFlag::where('id', $model->id)->uninvite();

        $model = EntityWithInvitedFlag::withUninvited()->where('id', $model->id)->first();

        $this->assertFalse($model->is_invited);
    }

    /** @test */
    public function it_can_skip_apply()
    {
        factory(EntityWithInvitedFlag::class, 3)->create([
            'is_invited' => true,
        ]);
        factory(EntityWithInvitedFlag::class, 2)->create([
            'is_invited' => false,
        ]);

        $entities = EntityWithInvitedFlagUnapplied::all();

        $this->assertCount(5, $entities);
    }
}
