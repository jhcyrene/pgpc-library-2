import { usePage } from '@inertiajs/react';

import StudentLayout from '../../../Layouts/StudentLayout';
import BorrowTable from '../../../components/student/BorrowTable';

export default function Overview({ borrowing }) {
    const { routes } = usePage().props.studentPortal;
    return <StudentLayout title="My Borrows" active="current-borrows"><div className="mx-auto w-full max-w-[1500px] space-y-5"><section className="rounded-2xl bg-[#102b70] p-6 text-white shadow-md"><p className="text-xs font-bold uppercase tracking-[0.16em] text-blue-200">My Library</p><h1 className="mt-2 text-3xl font-black">Borrowing overview</h1><p className="mt-2 text-sm text-slate-300">See your active loans and latest returned books.</p></section><OverviewPanel title="Current borrows" href={routes.currentBorrows}><BorrowTable borrows={borrowing.current} mode="current" /></OverviewPanel><OverviewPanel title="Recent history" href={routes.borrowHistory}><BorrowTable borrows={borrowing.history} mode="history" /></OverviewPanel></div></StudentLayout>;
}

function OverviewPanel({ title, href, children }) {
    return <section className="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm"><div className="mb-4 flex items-center justify-between"><h2 className="text-lg font-extrabold text-slate-900">{title}</h2><a href={href} className="rounded-lg bg-blue-50 px-4 py-2 text-xs font-bold text-blue-700">View all</a></div>{children}</section>;
}
