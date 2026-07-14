<?php

namespace App\Http\Controllers;

use App\Models\BookData;
use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CatalogController extends Controller
{
    /**
     * Display the public library catalog.
     */
    public function index(Request $request): View
    {
        $rawSearch = (string) ($request->query('q') ?? $request->query('search', ''));
        $search = trim(preg_replace('/\s+/u', ' ', $rawSearch) ?? $rawSearch);
        $search = mb_substr($search, 0, 150);

        $categoryInput = $request->query('category', $request->query('category_id', []));
        if (!is_array($categoryInput) && $categoryInput !== '') {
            $categoryInput = [$categoryInput];
        }
        $selectedCategoryIds = array_filter(array_map('strval', (array) $categoryInput));

        $selectedCategoryId = null;
        if (!empty($selectedCategoryIds)) {
            $selectedCategoryId = ctype_digit($selectedCategoryIds[0]) ? (int) $selectedCategoryIds[0] : null;
        }

        if ($selectedCategoryId === null && count($selectedCategoryIds) === 1 && !ctype_digit($selectedCategoryIds[0])) {
            $foundCatId = Category::query()
                ->whereRaw('LOWER(category_name) = ?', [mb_strtolower($selectedCategoryIds[0])])
                ->value('category_id');

            if ($foundCatId) {
                $selectedCategoryId = $foundCatId;
                $selectedCategoryIds = [(string) $foundCatId];
            } else if ($search === '') {
                $search = $selectedCategoryIds[0];
                $selectedCategoryIds = [];
            }
        }

        $sortOptions = [
            'title_asc' => 'Title: A to Z',
            'title_desc' => 'Title: Z to A',
            'newest' => 'Newest records',
            'oldest' => 'Oldest records',
            'availability' => 'Most available',
        ];

        $sort = (string) $request->query('sort', 'title_asc');
        if (! array_key_exists($sort, $sortOptions)) {
            $sort = 'title_asc';
        }

        $statusOptions = [
            'Available' => 'Available',
            'Checked Out' => 'Checked Out',
            'Lost' => 'Lost',
            'Damaged' => 'Damaged',
        ];
        $selectedStatuses = array_filter((array) $request->query('status', []));

        $yearFrom = $request->query('year_from');
        $yearTo = $request->query('year_to');

        $query = BookData::query()
            ->with([
                'authors:author_id,first_name,middle_name,last_name,suffix',
                'categories:category_id,category_name',
                'bookDetail.publisher',
            ])
            ->withCount([
                'books as copies_total',
                'books as copies_available' => function (Builder $query): void {
                    $query->whereRaw('LOWER(books.status) = ?', ['available']);
                },
            ]);

        if ($search !== '') {
            $terms = preg_split('/\s+/u', mb_strtolower($search), -1, PREG_SPLIT_NO_EMPTY) ?: [];

            foreach ($terms as $term) {
                $pattern = "%{$term}%";

                $query->where(function (Builder $query) use ($pattern): void {
                    $query->whereRaw('LOWER(book_data.book_title) LIKE ?', [$pattern])
                        ->orWhereRaw('LOWER(book_data.subtitle) LIKE ?', [$pattern])
                        ->orWhereHas('bookDetail', function (Builder $detailQuery) use ($pattern): void {
                            $detailQuery->whereRaw('LOWER(book_details.isbn) LIKE ?', [$pattern])
                                ->orWhereRaw('LOWER(book_details.issn) LIKE ?', [$pattern])
                                ->orWhereRaw('LOWER(book_details.call_number) LIKE ?', [$pattern]);
                        })
                        ->orWhereHas('authors', function (Builder $authorQuery) use ($pattern): void {
                            $authorQuery->whereRaw('LOWER(authors.first_name) LIKE ?', [$pattern])
                                ->orWhereRaw('LOWER(authors.middle_name) LIKE ?', [$pattern])
                                ->orWhereRaw('LOWER(authors.last_name) LIKE ?', [$pattern])
                                ->orWhereRaw('LOWER(authors.suffix) LIKE ?', [$pattern]);
                        });
                });
            }
        }

        if (!empty($selectedCategoryIds)) {
            $query->whereHas('categories', function (Builder $query) use ($selectedCategoryIds): void {
                $query->whereIn('categories.category_id', $selectedCategoryIds);
            });
        }

        if (!empty($yearFrom) || !empty($yearTo)) {
            $query->whereHas('bookDetail', function (Builder $q) use ($yearFrom, $yearTo): void {
                if (!empty($yearFrom)) {
                    $q->where('publication_year', '>=', $yearFrom);
                }
                if (!empty($yearTo)) {
                    $q->where('publication_year', '<=', $yearTo);
                }
            });
        }

        if (!empty($selectedStatuses)) {
            $query->whereHas('books', function (Builder $q) use ($selectedStatuses): void {
                $q->whereIn('status', $selectedStatuses);
            });
        }

        match ($sort) {
            'title_desc' => $query
                ->orderByRaw('LOWER(book_data.book_title) DESC')
                ->orderByDesc('book_data.book_data_id'),
            'newest' => $query
                ->orderByDesc('book_data.created_at')
                ->orderByDesc('book_data.book_data_id'),
            'oldest' => $query
                ->orderBy('book_data.created_at')
                ->orderBy('book_data.book_data_id'),
            'availability' => $query
                ->orderByDesc('copies_available')
                ->orderByRaw('LOWER(book_data.book_title) ASC'),
            default => $query
                ->orderByRaw('LOWER(book_data.book_title) ASC')
                ->orderBy('book_data.book_data_id'),
        };

        $books = $query->paginate(12)->withQueryString();
        $categories = Category::query()
            ->select(['category_id', 'category_name'])
            ->orderByRaw('LOWER(category_name) ASC')
            ->get();

        return view('opac.index', compact(
            'books',
            'categories',
            'search',
            'selectedCategoryId',
            'sort',
            'sortOptions',
            'statusOptions',
            'selectedStatuses',
            'selectedCategoryIds',
            'yearFrom',
            'yearTo'
        ));
    }
}
