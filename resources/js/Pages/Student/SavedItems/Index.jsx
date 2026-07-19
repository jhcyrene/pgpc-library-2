import { router, usePage } from '@inertiajs/react';
import { useState } from 'react';

import StudentLayout from '../../../Layouts/StudentLayout';

export default function Index({ savedItems }) {
    const { flash, studentPortal } = usePage().props;

    return (
        <StudentLayout title="Saved Items" active="saved">
            <div className="mx-auto w-full max-w-[1500px] space-y-5">
                <section className="flex flex-col gap-4 rounded-2xl bg-[#102b70] p-6 text-white shadow-md sm:flex-row sm:items-end sm:justify-between">
                    <div><p className="text-xs font-bold uppercase tracking-[0.16em] text-blue-200">My Library</p><h1 className="mt-2 text-3xl font-black">My saved items</h1><p className="mt-2 text-sm text-slate-300">Books you bookmarked for easy access later.</p></div>
                    <a href={studentPortal.routes.catalog} className="rounded-xl bg-[#fcc719] px-5 py-3 text-center text-sm font-bold text-[#102b70]">Browse catalog</a>
                </section>

                {flash?.success && <div role="status" className="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-bold text-emerald-700">{flash.success}</div>}
                {flash?.error && <div role="alert" className="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-bold text-red-700">{flash.error}</div>}

                {savedItems.data.length ? (
                    <>
                        <div className="flex items-center justify-between"><p className="text-sm font-semibold text-slate-500">{savedItems.meta.total} saved {savedItems.meta.total === 1 ? 'title' : 'titles'}</p>{savedItems.meta.total > 0 && <p className="text-xs text-slate-400">Showing {savedItems.meta.from}–{savedItems.meta.to}</p>}</div>
                        <section className="grid gap-5 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                            {savedItems.data.map((item) => <SavedCard key={item.id} item={item} />)}
                        </section>
                        <Pagination savedItems={savedItems} />
                    </>
                ) : <EmptyState catalogUrl={studentPortal.routes.catalog} />}
            </div>
        </StudentLayout>
    );
}

function SavedCard({ item }) {
    const [removing, setRemoving] = useState(false);
    const remove = () => {
        setRemoving(true);
        router.delete(item.actions.remove, {
            preserveScroll: true,
            onFinish: () => setRemoving(false),
        });
    };

    return (
        <article className="group flex overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:-translate-y-0.5 hover:shadow-md sm:flex-col">
            <div className="aspect-[2/3] w-32 shrink-0 overflow-hidden bg-gradient-to-br from-slate-50 to-slate-200 sm:w-full">
                {item.coverUrl ? <img src={item.coverUrl} alt={`Cover of ${item.title}`} className="h-full w-full object-cover" /> : <div className="flex h-full flex-col items-center justify-center p-4 text-center text-[#102b70]"><span className="text-4xl" aria-hidden="true">📖</span><span className="mt-2 text-[10px] font-extrabold uppercase tracking-wider">PGPC Library</span></div>}
            </div>
            <div className="flex min-w-0 flex-1 flex-col p-4">
                <p className="text-[10px] font-bold uppercase tracking-wide text-slate-400">Saved {item.savedAt || 'recently'}</p>
                <h2 className="mt-1.5 line-clamp-2 text-base font-extrabold leading-snug text-slate-900" title={item.title}>{item.title}</h2>
                <p className="mt-1 line-clamp-2 text-xs text-slate-500">{item.authors.length ? `by ${item.authors.join(', ')}` : 'Unknown author'}</p>
                <div className="mt-auto flex gap-2 pt-5"><a href={item.actions.reserve} className="flex-1 rounded-lg bg-[#102b70] px-3 py-2.5 text-center text-xs font-bold text-white">Reserve</a><button type="button" onClick={remove} disabled={removing} className="rounded-lg border border-red-200 px-3 py-2.5 text-xs font-bold text-red-600 hover:bg-red-50 disabled:opacity-50">{removing ? 'Removing…' : 'Remove'}</button></div>
            </div>
        </article>
    );
}

function EmptyState({ catalogUrl }) {
    return <section className="rounded-2xl border border-slate-200 bg-white px-6 py-16 text-center shadow-sm"><div className="text-5xl" aria-hidden="true">🔖</div><h2 className="mt-4 text-xl font-extrabold text-slate-900">No saved items yet</h2><p className="mx-auto mt-2 max-w-md text-sm leading-relaxed text-slate-500">Bookmark interesting titles while browsing the catalog and they will appear here.</p><a href={catalogUrl} className="mt-6 inline-block rounded-xl bg-[#102b70] px-5 py-3 text-sm font-bold text-white">Browse catalog</a></section>;
}

function Pagination({ savedItems }) {
    if (savedItems.meta.lastPage <= 1) return null;
    return <nav className="flex items-center justify-between rounded-xl border border-slate-200 bg-white p-3 shadow-sm" aria-label="Saved items pagination"><a href={savedItems.links.previous || undefined} aria-disabled={!savedItems.links.previous} className={`rounded-lg px-4 py-2 text-sm font-bold ${savedItems.links.previous ? 'text-slate-700 hover:bg-slate-100' : 'pointer-events-none text-slate-300'}`}>Previous</a><span className="text-xs font-semibold text-slate-500">Page {savedItems.meta.currentPage} of {savedItems.meta.lastPage}</span><a href={savedItems.links.next || undefined} aria-disabled={!savedItems.links.next} className={`rounded-lg px-4 py-2 text-sm font-bold ${savedItems.links.next ? 'text-slate-700 hover:bg-slate-100' : 'pointer-events-none text-slate-300'}`}>Next</a></nav>;
}
