<?php

namespace Modules\ATG\Tests\Feature\Controllers;

use Modules\ATG\Models\Item;
use Tests\TestCase;

class ItemControllerTest extends TestCase
{
    public function testGetIndexItems()
    {
        $item = Item::factory()->create();

        $this->get('/api/items')->assertStatus(200)
            ->assertJsonFragment([
                'status' => true,
                'messages' => []
            ])
            ->assertJsonPath('data.items.0.uuid', $item->uuid)
            ->assertJsonPath('data.total', 1);
    }
}
