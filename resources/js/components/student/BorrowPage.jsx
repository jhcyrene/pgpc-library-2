import BorrowTable from './BorrowTable';

export default function BorrowPage({ title, description, borrows, mode, sort, sortOptions, actions }) {
    return (
        <div className="mx-auto w-full max-w-[1500px] space-y-5">
            <section className="flex flex-col gap-4 rounded-2xl bg-[#102b70] p-6 text-white shadow-md sm:flex-row sm:items-end sm:justify-between">
                <div><p className="text-xs font-bold uppercase tracking-[0.16em] text-blue-200">My Library</p><h1 className="mt-2 text-3xl font-black">{title}</h1><p className="mt-2 max-w-2xl text-sm text-slate-300">{description}</p></div>
                {actions}
            </section>
            <section className="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div className="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between"><div><h2 className="text-lg font-extrabold text-slate-900">{borrows.meta.total} {borrows.meta.total === 1 ? 'record' : 'records'}</h2>{borrows.meta.total > 0 && <p className="text-xs text-slate-500">Showing {borrows.meta.from}–{borrows.meta.to}</p>}</div>{sortOptions && <SortControl value={sort} options={sortOptions} />}</div>
                <BorrowTable borrows={borrows.data} mode={mode} />
                <Pagination pagination={borrows} />
            </section>
        </div>
    );
}

function SortControl({ value, options }) {
    return <form method="GET"><label className="flex items-center gap-2 text-xs font-bold text-slate-500">Sort by<select name="sort" defaultValue={value || options[0][0]} onChange={(event) => event.currentTarget.form.submit()} className="rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-700">{options.map(([optionValue, label]) => <option key={optionValue} value={optionValue}>{label}</option>)}</select></label></form>;
}

function Pagination({ pagination }) {
    if (pagination.meta.lastPage <= 1) return null;
    return <nav className="mt-5 flex items-center justify-between border-t border-slate-100 pt-4" aria-label="Pagination"><a href={pagination.links.previous || undefined} aria-disabled={!pagination.links.previous} className={`rounded-lg border px-4 py-2 text-sm font-bold ${pagination.links.previous ? 'border-slate-200 text-slate-700 hover:bg-slate-50' : 'pointer-events-none border-slate-100 text-slate-300'}`}>Previous</a><span className="text-xs font-semibold text-slate-500">Page {pagination.meta.currentPage} of {pagination.meta.lastPage}</span><a href={pagination.links.next || undefined} aria-disabled={!pagination.links.next} className={`rounded-lg border px-4 py-2 text-sm font-bold ${pagination.links.next ? 'border-slate-200 text-slate-700 hover:bg-slate-50' : 'pointer-events-none border-slate-100 text-slate-300'}`}>Next</a></nav>;
}
