<?php

/*
 * This file is part of Laravel Eloquent Flag.
 *
 * (c) Anton Komarev <a.komarev@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cog\Tests\Flag\Unit\Traits\Classic;

use Carbon\Carbon;
use Cog\Tests\Flag\Stubs\Models\Classic\EntityWithKeptFlag;
use Cog\Tests\Flag\TestCase;

class HasKeptFlagHelperTest extends TestCase
{
    /** @test */
    public function it_can_set_kept_flag()
    {
        $entity = factory(EntityWithKeptFlag::class)->create([
            'is_kept' => false,
        ]);

        $entity->setKeptFlag();

        $this->assertTrue($entity->is_kept);
    }

    /** @test */
    public function it_can_unset_kept_flag()
    {
        $entity = factory(EntityWithKeptFlag::class)->create([
            'is_kept' => true,
        ]);

        $entity->unsetKeptFlag();

        $this->assertFalse($entity->is_kept);
    }

    /** @test */
    public function it_can_check_if_entity_is_kept()
    {
        $keptEntity = factory(EntityWithKeptFlag::class)->create([
            'is_kept' => true,
        ]);

        $unkeptEntity = factory(EntityWithKeptFlag::class)->create([
            'is_kept' => false,
        ]);

        $this->assertTrue($keptEntity->isKept());
        $this->assertFalse($unkeptEntity->isKept());
    }

    /** @test */
    public function it_can_check_if_entity_is_unkept()
    {
        $keptEntity = factory(EntityWithKeptFlag::class)->create([
            'is_kept' => true,
        ]);

        $unkeptEntity = factory(EntityWithKeptFlag::class)->create([
            'is_kept' => false,
        ]);

        $this->assertFalse($keptEntity->isUnkept());
        $this->assertTrue($unkeptEntity->isUnkept());
    }

    /** @test */
    public function it_can_verify_entity()
    {
        $entity = factory(EntityWithKeptFlag::class)->create([
            'is_kept' => false,
        ]);

        $entity->keep();

        $this->assertTrue($entity->is_kept);
    }

    /** @test */
    public function it_can_unkeep_entity()
    {
        $entity = factory(EntityWithKeptFlag::class)->create([
            'is_kept' => true,
        ]);

        $entity->unkeep();

        $this->assertFalse($entity->is_kept);
    }

    /** @test */
    public function it_can_get_unkept_older_than_hours()
    {
        factory(EntityWithKeptFlag::class, 3)->create([
            'is_kept' => true,
            'created_at' => Carbon::now()->subHours(4)->toDateTimeString(),
        ]);
        factory(EntityWithKeptFlag::class, 2)->create([
            'is_kept' => false,
            'created_at' => Carbon::now()->subHours(4)->toDateTimeString(),
        ]);
        factory(EntityWithKeptFlag::class, 2)->create([
            'is_kept' => false,
            'created_at' => Carbon::now()->subHours(2)->toDateTimeString(),
        ]);
        factory(EntityWithKeptFlag::class, 2)->create([
            'is_kept' => false,
        ]);

        $entities = EntityWithKeptFlag::onlyUnkeptOlderThanHours(4)->get();

        $this->assertCount(2, $entities);
    }
}
