<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\BookData;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicNavigationTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_and_catalog_routes_render_with_working_navigation(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertSee(route('opac.index'), false)
            ->assertSee('finishPreloader', false);

        $this->get(route('opac.index'))
            ->assertOk()
            ->assertSee('Library Catalog');
    }

    public function test_catalog_search_returns_real_titles_and_availability(): void
    {
        $bookData = BookData::factory()->create([
            'book_title' => 'Applied Quantum Research',
        ]);
        Book::factory()->create([
            'book_data_id' => $bookData->book_data_id,
            'status' => 'Available',
        ]);

        $this->get(route('opac.index', ['q' => 'quantum']))
            ->assertOk()
            ->assertSee('Applied Quantum Research')
            ->assertSee('1 of 1 available');

        $this->get(route('opac.index', ['q' => 'nonexistent-title']))
            ->assertOk()
            ->assertDontSee('Applied Quantum Research');
    }
}
