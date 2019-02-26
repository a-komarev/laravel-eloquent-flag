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
use Cog\Tests\Flag\Stubs\Models\Inverse\EntityWithClosedAt;
use Cog\Tests\Flag\TestCase;

class HasClosedAtHelpersTest extends TestCase
{
    /** @test */
    public function it_can_set_closed_flag()
    {
        $entity = factory(EntityWithClosedAt::class)->create([
            'closed_at' => null,
        ]);

        $entity->setClosedFlag();

        $this->assertNotNull($entity->closed_at);
    }

    /** @test */
    public function it_can_unset_closed_flag()
    {
        $entity = factory(EntityWithClosedAt::class)->create([
            'closed_at' => Carbon::now(),
        ]);

        $entity->unsetClosedFlag();

        $this->assertNull($entity->closed_at);
    }

    /** @test */
    public function it_can_check_if_entity_is_closed()
    {
        $closedEntity = factory(EntityWithClosedAt::class)->create([
            'closed_at' => Carbon::now(),
        ]);

        $openedEntity = factory(EntityWithClosedAt::class)->create([
            'closed_at' => null,
        ]);

        $this->assertTrue($closedEntity->isClosed());
        $this->assertFalse($openedEntity->isClosed());
    }

    /** @test */
    public function it_can_check_if_entity_is_opened()
    {
        $closedEntity = factory(EntityWithClosedAt::class)->create([
            'closed_at' => Carbon::now(),
        ]);

        $openedEntity = factory(EntityWithClosedAt::class)->create([
            'closed_at' => null,
        ]);

        $this->assertFalse($closedEntity->isOpened());
        $this->assertTrue($openedEntity->isOpened());
    }

    /** @test */
    public function it_can_close_entity()
    {
        $entity = factory(EntityWithClosedAt::class)->create([
            'closed_at' => null,
        ]);

        $entity->close();

        $this->assertNotNull($entity->closed_at);
    }

    /** @test */
    public function it_can_open_entity()
    {
        $entity = factory(EntityWithClosedAt::class)->create([
            'closed_at' => Carbon::now(),
        ]);

        $entity->open();

        $this->assertNull($entity->closed_at);
    }
}
