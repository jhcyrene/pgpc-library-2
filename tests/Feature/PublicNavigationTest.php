<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\BookData;
use App\Models\Member;
use App\Models\MemberAuth;
use App\Models\SavedItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class PublicNavigationTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_and_catalog_routes_render_with_working_navigation(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('Public/Home')
                ->where('routes.home', route('home'))
                ->where('routes.opac', route('opac.index'))
                ->where('routes.login', route('login'))
                ->where('routes.register', route('register'))
                ->where('auth.user', null)
            );

        $this->get(route('opac.index'))
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('Public/Catalog')
                ->where('catalog.meta.total', 0)
                ->where('filters.sort', 'title_asc')
                ->where('routes.opac', route('opac.index'))
                ->where('routes.advancedSearch', route('opac.search'))
            );
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
            ->assertInertia(fn (Assert $page) => $page
                ->component('Public/Catalog')
                ->where('filters.search', 'quantum')
                ->where('catalog.meta.total', 1)
                ->has('catalog.data', 1)
                ->where('catalog.data.0.title', 'Applied Quantum Research')
                ->where('catalog.data.0.copies.available', 1)
                ->where('catalog.data.0.copies.total', 1)
            );

        $this->get(route('opac.index', ['q' => 'nonexistent-title']))
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('Public/Catalog')
                ->where('catalog.meta.total', 0)
                ->has('catalog.data', 0)
            );
    }

    public function test_advanced_search_page_and_exact_title_query_use_inertia(): void
    {
        BookData::factory()->create(['book_title' => 'Exact Catalog Title']);
        BookData::factory()->create(['book_title' => 'Exact Catalog Title Companion']);

        $this->get(route('opac.search'))
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('Public/AdvancedSearch')
                ->where('routes.opac', route('opac.index'))
            );

        $this->get(route('opac.index', [
            'title' => 'Exact Catalog Title',
            'title_exact' => 'on',
        ]))->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('Public/Catalog')
                ->where('catalog.meta.total', 1)
                ->where('catalog.data.0.title', 'Exact Catalog Title')
            );
    }

    public function test_catalog_exposes_student_actions_and_saved_state_as_explicit_props(): void
    {
        $member = Member::factory()->create();
        $account = MemberAuth::factory()->create([
            'member_id' => $member->member_id,
            'username' => 'catalog.student',
            'account_type' => 'Member',
            'account_status' => 'Active',
            'password_hash' => Hash::make('password123'),
        ]);
        $bookData = BookData::factory()->create();
        SavedItem::create([
            'member_id' => $member->member_id,
            'book_data_id' => $bookData->book_data_id,
        ]);

        $this->actingAs($account, 'member')
            ->get(route('opac.index'))
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('Public/Catalog')
                ->where('catalog.data.0.id', $bookData->book_data_id)
                ->where('catalog.data.0.isSaved', true)
                ->where('catalog.data.0.actions.reservationAllowed', true)
                ->where('catalog.data.0.actions.save', route('student.saved-items.store', $bookData))
                ->where('catalog.data.0.actions.unsave', route('student.saved-items.destroy', $bookData))
                ->where('catalog.data.0.actions.reserve', route('student.reservations.create', $bookData))
            );
    }
}
