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

namespace Cog\Tests\Flag\Unit\Traits\Inverse;

use Cog\Tests\Flag\Stubs\Models\Inverse\EntityWithClosedFlag;
use Cog\Tests\Flag\TestCase;

final class HasClosedFlagHelpersTest extends TestCase
{
    /** @test */
    public function it_can_set_closed_flag(): void
    {
        $entity = factory(EntityWithClosedFlag::class)->create([
            'is_closed' => false,
        ]);

        $entity->setClosedFlag();

        $this->assertTrue($entity->is_closed);
    }

    /** @test */
    public function it_can_unset_closed_flag(): void
    {
        $entity = factory(EntityWithClosedFlag::class)->create([
            'is_closed' => true,
        ]);

        $entity->unsetClosedFlag();

        $this->assertFalse($entity->is_closed);
    }

    /** @test */
    public function it_can_check_if_entity_is_closed(): void
    {
        $closedEntity = factory(EntityWithClosedFlag::class)->create([
            'is_closed' => true,
        ]);

        $openedEntity = factory(EntityWithClosedFlag::class)->create([
            'is_closed' => false,
        ]);

        $this->assertTrue($closedEntity->isClosed());
        $this->assertFalse($openedEntity->isClosed());
    }

    /** @test */
    public function it_can_check_if_entity_is_opened(): void
    {
        $closedEntity = factory(EntityWithClosedFlag::class)->create([
            'is_closed' => true,
        ]);

        $openedEntity = factory(EntityWithClosedFlag::class)->create([
            'is_closed' => false,
        ]);

        $this->assertFalse($closedEntity->isOpened());
        $this->assertTrue($openedEntity->isOpened());
    }

    /** @test */
    public function it_can_close_entity(): void
    {
        $entity = factory(EntityWithClosedFlag::class)->create([
            'is_closed' => false,
        ]);

        $entity->close();

        $this->assertTrue($entity->is_closed);
    }

    /** @test */
    public function it_can_open_entity(): void
    {
        $entity = factory(EntityWithClosedFlag::class)->create([
            'is_closed' => true,
        ]);

        $entity->open();

        $this->assertFalse($entity->is_closed);
    }
}
