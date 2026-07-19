import { usePage } from '@inertiajs/react';

import StudentLayout from '../../Layouts/StudentLayout';

export default function Dashboard({ dashboard }) {
    const { studentPortal } = usePage().props;
    const { student, routes } = studentPortal;
    const summaryCards = [
        ['Active Borrows', dashboard.summary.activeBorrows, 'Books currently on your account', routes.currentBorrows],
        ['Overdue Items', dashboard.summary.overdueItems, 'Past their scheduled due date', routes.overdue],
        ['Reservations', dashboard.summary.pendingReservations, 'Pending library requests', routes.reservations],
        ['Books Borrowed', dashboard.summary.totalBooksBorrowed, 'Your complete circulation history', routes.borrowHistory],
    ];

    return (
        <StudentLayout title="Dashboard" active="dashboard">
            <div className="mx-auto w-full max-w-[1600px] space-y-5">
                <section className="grid gap-5 xl:grid-cols-[minmax(0,2.2fr)_minmax(280px,0.8fr)]">
                    <div className="relative flex min-h-[220px] flex-col justify-between overflow-hidden rounded-2xl bg-[#102b70] p-6 shadow-md md:p-7"><div className="absolute -right-10 -top-10 h-64 w-64 rounded-full bg-white/5 blur-3xl" /><div className="relative z-10"><p className="mb-4 text-xs font-bold uppercase tracking-wider text-white/60">{dashboard.dateLabel}</p><h1 className="text-3xl font-extrabold leading-tight text-white md:text-4xl">Good {dashboard.greeting}, <span className="text-[#fcc719]">{student.firstName}</span></h1><p className="mt-2 max-w-xl text-sm font-medium leading-relaxed text-slate-300">Review your borrowed books, reservations, and due dates from one place.</p><div className="mt-5 flex flex-wrap gap-6 text-xs font-semibold text-slate-300"><span><strong className="text-white">{dashboard.summary.readyForPickup}</strong> ready for pickup</span><span><strong className="text-white">₱{Number(dashboard.summary.outstandingFines).toFixed(2)}</strong> fine balance</span></div><div className="mt-6 flex flex-col gap-3 sm:flex-row"><a href={routes.catalog} className="rounded-xl bg-[#fcc719] px-6 py-3 text-center text-sm font-bold text-[#102b70]">Browse Catalog</a><a href={routes.currentBorrows} className="rounded-xl border border-white/15 bg-white/10 px-6 py-3 text-center text-sm font-bold text-white">My Current Borrows</a></div></div></div>
                    <Attention items={dashboard.attentionItems} />
                </section>

                <section className="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">{summaryCards.map(([title, value, description, href]) => <a key={title} href={href} className="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:shadow-md"><p className="text-xs font-bold uppercase tracking-wide text-slate-500">{title}</p><p className="mt-1.5 text-2xl font-black text-slate-900">{value}</p><p className="mt-2 text-xs font-medium text-slate-400">{description}</p></a>)}</section>

                <section className="grid gap-5 xl:grid-cols-[minmax(0,2.2fr)_minmax(280px,0.8fr)]">
                    <Panel title="Current Borrows" subtitle="Books assigned to your library account" link={routes.currentBorrows}>
                        {dashboard.currentBorrows.length ? <div className="overflow-x-auto rounded-xl border border-slate-200"><table className="w-full min-w-[38rem] text-left text-sm"><thead className="border-b border-slate-200 bg-slate-50 text-xs uppercase text-slate-500"><tr><th className="px-5 py-3.5">Book</th><th className="px-5 py-3.5">Accession No.</th><th className="px-5 py-3.5">Due Date</th><th className="px-5 py-3.5 text-right">Status</th></tr></thead><tbody className="divide-y divide-slate-100">{dashboard.currentBorrows.map((borrow) => <tr key={borrow.id}><td className="px-5 py-4 font-bold text-slate-900">{borrow.title}</td><td className="px-5 py-4 text-xs text-slate-500">{borrow.accessionNumber || '—'}</td><td className="px-5 py-4 text-xs">{borrow.dueDate || '—'}</td><td className="px-5 py-4 text-right"><span className={`rounded-md border px-2.5 py-1 text-xs font-bold ${borrow.isOverdue ? 'border-red-200 bg-red-50 text-red-700' : 'border-emerald-200 bg-emerald-50 text-emerald-700'}`}>{borrow.isOverdue ? 'Overdue' : 'Active'}</span></td></tr>)}</tbody></table></div> : <Empty message="No books are currently borrowed" action="Search the catalog" href={routes.catalog} />}
                    </Panel>
                    <Panel title="Reservations" subtitle="Your latest active requests" link={routes.reservations}>{dashboard.reservations.length ? <div className="space-y-3">{dashboard.reservations.map((reservation) => <a key={reservation.id} href={reservation.showUrl} className="block rounded-xl border border-slate-100 p-3 hover:bg-slate-50"><p className="font-bold text-slate-900">{reservation.title}</p><div className="mt-1 flex justify-between text-xs text-slate-500"><span>{reservation.requestDate || '—'}</span><span className="font-bold text-[#102b70]">{reservation.status}</span></div></a>)}</div> : <Empty message="No active reservations" action="Browse the catalog" href={routes.catalog} />}</Panel>
                </section>
            </div>
        </StudentLayout>
    );
}

function Attention({ items }) {
    const colors = { overdue: 'border-red-100 bg-red-50 text-red-700', ready: 'border-emerald-100 bg-emerald-50 text-emerald-700', fine: 'border-amber-100 bg-amber-50 text-amber-700' };
    return <div className="flex min-h-[220px] flex-col rounded-2xl border border-slate-200 bg-white p-5 shadow-sm"><div className="mb-4 flex items-center justify-between"><div><h2 className="text-lg font-extrabold text-slate-900">Requires Attention</h2><p className="text-xs text-slate-500">Items that may need action</p></div><span className="grid h-8 min-w-8 place-items-center rounded-full bg-red-50 px-2 text-xs font-black text-red-700">{items.length}</span></div>{items.length ? <div className="max-h-44 space-y-3 overflow-y-auto">{items.slice(0, 4).map((item, index) => <a key={`${item.type}-${index}`} href={item.actionUrl} className={`block rounded-xl border p-3 ${colors[item.type] || colors.fine}`}><p className="text-sm font-extrabold">{item.title}</p><p className="mt-1 line-clamp-2 text-xs opacity-80">{item.message}</p></a>)}</div> : <div className="flex flex-1 flex-col items-center justify-center text-center"><p className="text-3xl">✓</p><p className="mt-2 text-sm font-bold text-slate-800">You're all caught up</p><p className="mt-1 text-xs text-slate-500">No overdue, pickup, or fine alerts.</p></div>}</div>;
}

function Panel({ title, subtitle, link, children }) {
    return <div className="flex min-h-[280px] flex-col rounded-2xl border border-slate-200 bg-white p-5 shadow-sm"><div className="mb-4 flex items-center justify-between"><div><h2 className="text-lg font-extrabold text-slate-900">{title}</h2><p className="text-xs text-slate-500">{subtitle}</p></div><a href={link} className="rounded-lg bg-blue-50 px-4 py-2 text-xs font-bold text-blue-700">View all</a></div>{children}</div>;
}

function Empty({ message, action, href }) {
    return <div className="flex flex-1 flex-col items-center justify-center rounded-xl border border-dashed border-slate-200 bg-slate-50/60 py-8 text-center"><p className="text-sm font-bold text-slate-700">{message}</p><a href={href} className="mt-4 text-sm font-bold text-blue-700">{action}</a></div>;
}
