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
     * Display the advanced search page.
     */
    public function advancedSearch(): View
    {
        return view('opac.opacSearch');
    }

    /**
     * Display the public library catalog.
     */
    public function index(Request $request): View
    {
        $rawSearch = (string) ($request->query('q') ?? $request->query('search', ''));
        $search = trim(preg_replace('/\s+/u', ' ', $rawSearch) ?? $rawSearch);
        $search = mb_substr($search, 0, 150);

        $advTitle = trim((string) $request->query('title', ''));
        $advTitleExact = $request->query('title_exact') === 'on';

        $advAuthor = trim((string) $request->query('author', ''));
        $advAuthorExact = $request->query('author_exact') === 'on';

        $advSubject = trim((string) $request->query('subject', ''));
        $advSubjectExact = $request->query('subject_exact') === 'on';

        $advCallNumber = trim((string) $request->query('call_number', ''));
        $advCallNumberExact = $request->query('call_number_exact') === 'on';

        $advFormat = trim((string) $request->query('format', ''));

        $excludeOnOrder = $request->query('exclude_on_order') === 'on';
        $useOperators = $request->query('use_operators') === 'on';

        $limit = (int) $request->query('limit', 12);
        if ($limit <= 0) $limit = 12;

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
            'Not Available' => 'Not Available',
            'Checked Out' => 'Checked Out',
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
            $terms = $useOperators 
                ? [mb_strtolower($search)] 
                : (preg_split('/\s+/u', mb_strtolower($search), -1, PREG_SPLIT_NO_EMPTY) ?: []);

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

        if ($advTitle !== '') {
            if ($advTitleExact) {
                $query->whereRaw('LOWER(book_data.book_title) = ?', [mb_strtolower($advTitle)]);
            } else {
                $query->whereRaw('LOWER(book_data.book_title) LIKE ?', ['%' . mb_strtolower($advTitle) . '%']);
            }
        }

        if ($advAuthor !== '') {
            $query->whereHas('authors', function (Builder $q) use ($advAuthor, $advAuthorExact) {
                if ($advAuthorExact) {
                    $q->where(function($subQ) use ($advAuthor) {
                        $subQ->whereRaw('LOWER(first_name) = ?', [mb_strtolower($advAuthor)])
                             ->orWhereRaw('LOWER(last_name) = ?', [mb_strtolower($advAuthor)]);
                    });
                } else {
                    $pattern = '%' . mb_strtolower($advAuthor) . '%';
                    $q->where(function($subQ) use ($pattern) {
                        $subQ->whereRaw('LOWER(first_name) LIKE ?', [$pattern])
                             ->orWhereRaw('LOWER(last_name) LIKE ?', [$pattern]);
                    });
                }
            });
        }

        if ($advSubject !== '') {
            $query->whereHas('categories', function (Builder $q) use ($advSubject, $advSubjectExact) {
                if ($advSubjectExact) {
                    $q->whereRaw('LOWER(category_name) = ?', [mb_strtolower($advSubject)]);
                } else {
                    $q->whereRaw('LOWER(category_name) LIKE ?', ['%' . mb_strtolower($advSubject) . '%']);
                }
            });
        }

        if ($advCallNumber !== '') {
            $query->whereHas('bookDetail', function (Builder $q) use ($advCallNumber, $advCallNumberExact) {
                if ($advCallNumberExact) {
                    $q->whereRaw('LOWER(call_number) = ?', [mb_strtolower($advCallNumber)]);
                } else {
                    $q->whereRaw('LOWER(call_number) LIKE ?', ['%' . mb_strtolower($advCallNumber) . '%']);
                }
            });
        }

        if ($advFormat !== '') {
            $query->whereHas('bookDetail', function (Builder $q) use ($advFormat) {
                $q->whereRaw('LOWER(format) = ?', [mb_strtolower($advFormat)]);
            });
        }

        if ($excludeOnOrder) {
            $query->whereDoesntHave('books', function (Builder $q) {
                $q->whereRaw('LOWER(status) = ?', ['on order']);
            });
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
            $query->where(function (Builder $q) use ($selectedStatuses) {
                if (in_array('Available', $selectedStatuses)) {
                    $q->orWhereHas('books', function(Builder $bQ) {
                        $bQ->whereRaw('LOWER(status) = ?', ['available']);
                    });
                }
                if (in_array('Not Available', $selectedStatuses)) {
                    $q->orWhereDoesntHave('books', function(Builder $bQ) {
                        $bQ->whereRaw('LOWER(status) = ?', ['available']);
                    });
                }
                if (in_array('Checked Out', $selectedStatuses)) {
                    $q->orWhereHas('books', function(Builder $bQ) {
                        $bQ->whereRaw('LOWER(status) = ?', ['borrowed']);
                    });
                }
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

        $books = $query->paginate($limit)->withQueryString();
        $categories = Category::query()
            ->select(['category_id', 'category_name'])
            ->orderByRaw('LOWER(category_name) ASC')
            ->get();

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => true,
                'data' => [
                    'books' => $books->items(),
                    'total' => $books->total(),
                    'current_page' => $books->currentPage(),
                    'last_page' => $books->lastPage(),
                    'categories' => $categories,
                ]
            ]);
        }

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

    /**
     * Show a specific book's details in a modal for OPAC.
     */
    public function show(BookData $bookData, Request $request)
    {
        $bookData->load([
            'authors:author_id,first_name,middle_name,last_name,suffix',
            'categories:category_id,category_name',
            'bookDetail.publisher',
        ]);
        
        $bookData->loadCount([
            'books as copies_total',
            'books as copies_available' => function (Builder $query): void {
                $query->whereRaw('LOWER(books.status) = ?', ['available']);
            },
        ]);

        $memberAccount = \Illuminate\Support\Facades\Auth::guard('member')->user();
        $isStudentAccount = $memberAccount
            && $memberAccount->member_id
            && in_array(strtolower((string) $memberAccount->account_type), ['member', 'student'], true);

        $isSaved = false;
        if ($isStudentAccount && $memberAccount->member) {
            $isSaved = \App\Models\SavedItem::where('member_id', $memberAccount->member->member_id)
                ->where('book_data_id', $bookData->book_data_id)
                ->exists();
        }

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => true,
                'data' => [
                    'book' => $bookData,
                    'is_saved' => $isSaved,
                ]
            ]);
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'html' => view('components.opac.book-detail-content', compact('bookData', 'isStudentAccount', 'memberAccount', 'isSaved'))->render()
            ]);
        }
        
        return redirect()->route('opac.index');
    }
}
