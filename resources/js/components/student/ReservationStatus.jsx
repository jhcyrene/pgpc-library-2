const styles = {
    pending: 'border-amber-200 bg-amber-50 text-amber-700',
    approved: 'border-blue-200 bg-blue-50 text-blue-700',
    'ready for pickup': 'border-emerald-200 bg-emerald-50 text-emerald-700',
    completed: 'border-slate-200 bg-slate-50 text-slate-600',
    cancelled: 'border-red-200 bg-red-50 text-red-700',
    rejected: 'border-red-200 bg-red-50 text-red-700',
    expired: 'border-red-200 bg-red-50 text-red-700',
};

export default function ReservationStatus({ status, statusKey }) {
    return <span className={`inline-flex rounded-full border px-3 py-1 text-[11px] font-extrabold uppercase tracking-wide ${styles[statusKey] || styles.completed}`}>{status}</span>;
}

export function BookCover({ book, className = 'h-24 w-16' }) {
    return <div className={`shrink-0 overflow-hidden rounded-lg border border-slate-200 bg-gradient-to-br from-slate-50 to-slate-200 ${className}`}>{book.coverUrl ? <img src={book.coverUrl} alt={`Cover of ${book.title}`} className="h-full w-full object-cover" /> : <div className="flex h-full items-center justify-center text-2xl" aria-hidden="true">📖</div>}</div>;
}
