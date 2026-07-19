import { Head, router } from '@inertiajs/react';
import { useState } from 'react';

import PublicLayout from '../../Layouts/PublicLayout';
import backgroundImage from '../../../images/pgpc-ng.png';

export default function Catalog({ catalog, categories, filters, options, routes }) {
    const [search, setSearch] = useState(filters.search || '');
    const [filterState, setFilterState] = useState({
        statuses: filters.statuses || [],
        categoryIds: filters.categoryIds || [],
        yearFrom: filters.yearFrom || '',
        yearTo: filters.yearTo || '',
        sort: filters.sort || 'title_asc',
    });
    const [selectedBook, setSelectedBook] = useState(null);

    const visitCatalog = (overrides = {}) => {
        const params = {
            q: search || undefined,
            status: filterState.statuses.length ? filterState.statuses : undefined,
            category: filterState.categoryIds.length ? filterState.categoryIds : undefined,
            year_from: filterState.yearFrom || undefined,
            year_to: filterState.yearTo || undefined,
            sort: filterState.sort !== 'title_asc' ? filterState.sort : undefined,
            ...overrides,
        };
        router.get(routes.opac, params, { preserveScroll: true, preserveState: false });
    };

    const toggleArrayValue = (field, value) => {
        setFilterState((current) => ({
            ...current,
            [field]: current[field].includes(value)
                ? current[field].filter((item) => item !== value)
                : [...current[field], value],
        }));
    };

    const clearFilters = () => {
        setSearch('');
        setFilterState({ statuses: [], categoryIds: [], yearFrom: '', yearTo: '', sort: 'title_asc' });
        router.get(routes.opac);
    };

    return (
        <PublicLayout routes={routes} active="opac">
            <Head title="Online Public Access Catalog" />

            <section className="relative overflow-hidden bg-[#102b70] pb-14 pt-28 text-white sm:pb-16 sm:pt-32">
                <div className="absolute inset-0 bg-cover bg-center opacity-[0.08]" style={{ backgroundImage: `url(${backgroundImage})` }} />
                <div className="absolute inset-0 bg-gradient-to-r from-[#102b70]" />
                <div className="container relative z-10 mx-auto px-5 sm:px-6 md:px-12">
                    <div className="mx-auto max-w-5xl text-center">
                        <p className="text-xs font-bold uppercase text-[#fcc719]">PGPC Library System</p>
                        <h1 className="mt-3 text-3xl font-bold leading-tight tracking-tight text-white sm:text-4xl lg:text-6xl">Online Public Access Catalog</h1>
                        <p className="mx-auto mt-5 max-w-2xl text-base leading-7 text-blue-100 sm:text-lg">Search the library collection by title, author, ISBN, or call number and check each title's availability.</p>

                        <form onSubmit={(event) => { event.preventDefault(); visitCatalog({ page: undefined }); }} className="mx-auto mt-8 max-w-3xl">
                            <label htmlFor="catalog-search" className="sr-only">Search the library catalog</label>
                            <div className="flex flex-col gap-2 rounded-2xl bg-white p-2 shadow-lg sm:flex-row sm:items-center sm:rounded-full">
                                <input id="catalog-search" type="search" maxLength="150" value={search} onChange={(event) => setSearch(event.target.value)} placeholder="Title, author, ISBN, or call number" className="min-w-0 flex-1 border-0 bg-transparent px-4 py-3 text-base text-slate-800 outline-none placeholder:text-slate-400" />
                                <button type="submit" className="min-h-12 rounded-xl bg-[#fcc719] px-7 py-3 font-bold text-[#102b70] transition hover:bg-[#ffd84c] sm:rounded-full">Search Catalog</button>
                            </div>
                        </form>

                        <p className="mt-5 text-sm text-blue-100">Need more specific results? <a href={routes.advancedSearch} className="font-bold text-[#fcc719] underline underline-offset-4">Advanced Search</a></p>
                    </div>
                </div>
            </section>

            <section className="min-h-[55dvh] overflow-hidden bg-slate-50 py-8 sm:py-10">
                <div className="container mx-auto px-5 sm:px-6 md:px-12">
                    <div className="grid min-w-0 gap-5 lg:grid-cols-[16rem_minmax(0,1fr)] lg:items-start">
                        <aside className="min-w-0" aria-label="Catalog filters">
                            <form onSubmit={(event) => { event.preventDefault(); visitCatalog(); }} className="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm lg:sticky lg:top-24">
                                <div className="border-b border-slate-100 pb-4"><h2 className="font-bold text-[#102b70]">Filter Catalog</h2><p className="mt-0.5 text-xs text-slate-500">Refine the current results</p></div>

                                <FilterGroup title="Availability">
                                    {Object.entries(options.statuses).map(([value, label]) => <Checkbox key={value} label={label} checked={filterState.statuses.includes(value)} onChange={() => toggleArrayValue('statuses', value)} />)}
                                </FilterGroup>

                                <FilterGroup title="Category">
                                    <div className="max-h-52 space-y-2 overflow-y-auto pr-1">
                                        {categories.map((category) => <Checkbox key={category.id} label={category.name} checked={filterState.categoryIds.includes(String(category.id))} onChange={() => toggleArrayValue('categoryIds', String(category.id))} />)}
                                    </div>
                                </FilterGroup>

                                <FilterGroup title="Publication Year">
                                    <div className="flex items-center gap-2"><YearInput label="From" value={filterState.yearFrom} onChange={(value) => setFilterState((current) => ({ ...current, yearFrom: value }))} /><span className="text-slate-400">–</span><YearInput label="To" value={filterState.yearTo} onChange={(value) => setFilterState((current) => ({ ...current, yearTo: value }))} /></div>
                                </FilterGroup>

                                <FilterGroup title="Sort Results">
                                    <select value={filterState.sort} onChange={(event) => setFilterState((current) => ({ ...current, sort: event.target.value }))} className="w-full rounded-xl border border-slate-300 bg-white px-3 py-3 text-sm font-semibold text-slate-700 outline-none focus:border-[#102b70]">
                                        {Object.entries(options.sort).map(([value, label]) => <option key={value} value={value}>{label}</option>)}
                                    </select>
                                </FilterGroup>

                                <div className="mt-5 grid gap-2"><button type="submit" className="min-h-11 rounded-xl bg-[#102b70] px-5 py-3 font-bold text-white">Apply Filters</button><button type="button" onClick={clearFilters} className="min-h-10 rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-bold text-slate-600">Clear Filters</button></div>
                            </form>
                        </aside>

                        <div className="min-w-0">
                            <div className="mb-4 flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
                                <div><p className="text-xs font-bold uppercase tracking-[0.18em] text-[#102b70]">Catalog Results</p><h2 className="mt-1 text-2xl font-bold text-[#102b70] sm:text-3xl">{catalog.meta.total} {catalog.meta.total === 1 ? 'title' : 'titles'} found</h2></div>
                                {catalog.meta.total > 0 && <p className="text-sm text-slate-500">Showing {catalog.meta.from}–{catalog.meta.to}</p>}
                            </div>

                            {catalog.data.length === 0 ? (
                                <div className="rounded-3xl border border-dashed border-slate-300 bg-white px-6 py-16 text-center shadow-sm"><div className="text-4xl" aria-hidden="true">📚</div><h3 className="mt-5 text-xl font-bold text-slate-900">No catalog titles matched</h3><p className="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-500">Try a shorter search, choose a different category, or clear the filters to browse the collection.</p><button type="button" onClick={clearFilters} className="mt-6 rounded-xl bg-[#102b70] px-6 py-3 font-bold text-white">Browse All Titles</button></div>
                            ) : (
                                <div className="grid gap-4 xl:grid-cols-2">
                                    {catalog.data.map((book) => <BookCard key={book.id} book={book} onDetails={() => setSelectedBook(book)} />)}
                                </div>
                            )}

                            {catalog.meta.lastPage > 1 && <Pagination catalog={catalog} />}
                        </div>
                    </div>
                </div>
            </section>

            {selectedBook && <BookModal book={selectedBook} onClose={() => setSelectedBook(null)} />}
        </PublicLayout>
    );
}

function FilterGroup({ title, children }) {
    return <div className="mt-4 border-t border-slate-100 pt-4"><h3 className="mb-2 text-xs font-bold uppercase tracking-[0.12em] text-slate-500">{title}</h3>{children}</div>;
}

function Checkbox({ label, checked, onChange }) {
    return <label className="flex items-center gap-2.5 text-sm font-medium text-slate-700"><input type="checkbox" checked={checked} onChange={onChange} className="h-4 w-4 rounded border-slate-300 accent-[#102b70]" />{label}</label>;
}

function YearInput({ label, value, onChange }) {
    return <input type="number" inputMode="numeric" aria-label={`${label} publication year`} placeholder={label} min="1900" max={new Date().getFullYear()} value={value} onChange={(event) => onChange(event.target.value)} className="w-full min-w-0 rounded-xl border border-slate-300 px-3 py-2.5 text-sm outline-none focus:border-[#102b70]" />;
}

function BookCard({ book, onDetails }) {
    const available = book.copies.available > 0;
    return (
        <article className="flex min-w-0 gap-4 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm transition hover:border-[#102b70]/25 hover:shadow-md sm:p-5">
            <BookCover book={book} className="w-24 sm:w-28" />
            <div className="flex min-w-0 flex-1 flex-col">
                <div className="flex flex-wrap gap-1.5">{book.categories.slice(0, 2).map((category) => <span key={category} className="rounded-full bg-[#fcc719]/15 px-2 py-1 text-[10px] font-bold uppercase text-[#102b70]">{category}</span>)}</div>
                <h3 className="mt-2 break-words text-lg font-extrabold leading-snug text-slate-900">{book.title}</h3>
                {book.subtitle && <p className="mt-1 line-clamp-2 text-sm text-slate-500">{book.subtitle}</p>}
                <p className="mt-2 text-sm text-slate-600">By <span className="font-semibold">{book.authors.join(', ')}</span></p>
                <div className="mt-auto flex flex-col gap-3 pt-4 sm:flex-row sm:items-center sm:justify-between">
                    <p className={`text-sm font-semibold ${available ? 'text-emerald-700' : 'text-amber-700'}`}>{book.copies.available} of {book.copies.total} available</p>
                    <button type="button" onClick={onDetails} className="rounded-xl border border-[#102b70] px-4 py-2 text-sm font-bold text-[#102b70] hover:bg-blue-50">View Details</button>
                </div>
            </div>
        </article>
    );
}

function BookCover({ book, className = '' }) {
    return <div className={`aspect-[2/3] shrink-0 overflow-hidden rounded-xl border border-slate-200 bg-gradient-to-br from-slate-50 to-slate-200 ${className}`}>{book.coverUrl ? <img src={book.coverUrl} alt={`Cover of ${book.title}`} className="h-full w-full object-cover" /> : <div className="flex h-full flex-col items-center justify-center p-2 text-center text-[#102b70]"><span className="text-3xl" aria-hidden="true">📖</span><span className="mt-2 text-[9px] font-extrabold uppercase tracking-wider">PGPC Library</span></div>}</div>;
}

function Pagination({ catalog }) {
    return <nav className="mt-10 flex items-center justify-between rounded-2xl border border-slate-200 bg-white px-4 py-3 shadow-sm" aria-label="Catalog pagination"><a href={catalog.links.previous || '#'} aria-disabled={!catalog.links.previous} className={`rounded-lg px-4 py-2 text-sm font-bold ${catalog.links.previous ? 'text-[#102b70] hover:bg-blue-50' : 'pointer-events-none text-slate-300'}`}>Previous</a><span className="text-sm font-semibold text-slate-600">Page {catalog.meta.currentPage} of {catalog.meta.lastPage}</span><a href={catalog.links.next || '#'} aria-disabled={!catalog.links.next} className={`rounded-lg px-4 py-2 text-sm font-bold ${catalog.links.next ? 'text-[#102b70] hover:bg-blue-50' : 'pointer-events-none text-slate-300'}`}>Next</a></nav>;
}

function BookModal({ book, onClose }) {
    const available = book.copies.available > 0;
    const save = () => { onClose(); router.post(book.actions.save); };
    const unsave = () => { onClose(); router.delete(book.actions.unsave); };
    return (
        <div role="dialog" aria-modal="true" aria-labelledby="book-detail-title" className="fixed inset-0 z-[100] grid place-items-center bg-slate-950/60 p-0 sm:p-4">
            <div className="max-h-[94dvh] w-full max-w-3xl overflow-y-auto rounded-t-3xl bg-white shadow-2xl sm:rounded-3xl">
                <div className="sticky top-0 z-10 flex items-center justify-between bg-[#102b70] px-5 py-4 text-white"><div><p className="text-[10px] font-bold uppercase tracking-[0.2em] text-[#fcc719]">Library catalog</p><h2 id="book-detail-title" className="text-xl font-bold">Book Details</h2></div><button type="button" onClick={onClose} className="grid h-10 w-10 place-items-center rounded-full bg-white/10 text-xl" aria-label="Close book details">×</button></div>
                <div className="p-5 sm:p-8">
                    <div className="grid gap-6 sm:grid-cols-[10rem_minmax(0,1fr)]">
                        <BookCover book={book} className="mx-auto w-36 sm:w-40" />
                        <div className="min-w-0"><span className={`inline-flex rounded-full px-2.5 py-1 text-[10px] font-extrabold uppercase ${available ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700'}`}>{available ? 'Available' : 'Currently unavailable'}</span><h3 className="mt-3 text-2xl font-extrabold text-slate-950 sm:text-3xl">{book.title}</h3>{book.subtitle && <p className="mt-1.5 text-sm text-slate-500">{book.subtitle}</p>}<p className="mt-2.5 text-slate-600">By <span className="font-semibold">{book.authors.join(', ')}</span></p><dl className="mt-5 grid grid-cols-2 gap-2.5"><Detail label="Call number" value={book.details.callNumber} /><Detail label="ISBN / ISSN" value={book.details.isbn || book.details.issn} /><Detail label="Publisher" value={book.details.publisher} /><Detail label="Publication year" value={book.details.publicationYear} /></dl></div>
                    </div>
                    {book.description && <section className="mt-7 rounded-2xl border border-slate-200 p-5"><h4 className="font-bold text-slate-900">About this book</h4><p className="mt-2 text-sm leading-6 text-slate-600">{book.description}</p></section>}
                    <div className={`mt-7 rounded-2xl border p-4 ${available ? 'border-emerald-200 bg-emerald-50/60' : 'border-amber-200 bg-amber-50/60'}`}><div className="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between"><p className="font-semibold text-slate-700"><span className={available ? 'text-emerald-700' : 'text-amber-700'}>{book.copies.available}</span> of {book.copies.total} available</p><BookActions book={book} save={save} unsave={unsave} /></div></div>
                </div>
            </div>
        </div>
    );
}

function Detail({ label, value }) {
    return <div className="rounded-xl border border-slate-200 bg-slate-50 px-3.5 py-3"><dt className="text-[10px] font-extrabold uppercase tracking-wider text-slate-400">{label}</dt><dd className="mt-1 break-words text-sm font-bold text-slate-800">{value || 'Not available'}</dd></div>;
}

function BookActions({ book, save, unsave }) {
    if (book.actions.reservationAllowed) return <div className="flex flex-wrap gap-2"><button type="button" onClick={book.isSaved ? unsave : save} className="rounded-xl border border-[#102b70]/20 bg-white px-4 py-2 text-sm font-bold text-[#102b70]">{book.isSaved ? 'Remove Saved' : 'Save'}</button><a href={book.actions.reserve} className="rounded-xl bg-[#102b70] px-5 py-2 text-sm font-bold text-white">Reserve Book</a></div>;
    if (book.actions.staffAccount) return <p className="text-sm font-semibold text-slate-500">Reservations require a student account.</p>;
    return <a href={book.actions.login} className="rounded-xl bg-[#102b70] px-5 py-2 text-sm font-bold text-white">Log In to Reserve</a>;
}
