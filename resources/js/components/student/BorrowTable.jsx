export default function BorrowTable({ borrows, mode = 'current' }) {
    if (!borrows.length) {
        const messages = {
            current: 'You have no books currently borrowed.',
            history: 'Your borrowing history is empty.',
            overdue: 'You have no overdue books.',
        };

        return <div className="rounded-xl border border-dashed border-slate-300 bg-slate-50 px-6 py-12 text-center text-sm font-semibold text-slate-500">{messages[mode] || messages.current}</div>;
    }

    return (
        <div className="overflow-x-auto rounded-xl border border-slate-200">
            <table className="w-full min-w-[48rem] text-left text-sm">
                <thead className="border-b border-slate-200 bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                    <tr>
                        <th className="px-5 py-3.5">Book</th>
                        <th className="px-5 py-3.5">Accession No.</th>
                        <th className="px-5 py-3.5">Issued</th>
                        <th className="px-5 py-3.5">{mode === 'history' ? 'Returned' : 'Due'}</th>
                        {mode === 'overdue' && <th className="px-5 py-3.5">Fine</th>}
                        <th className="px-5 py-3.5 text-right">Status</th>
                    </tr>
                </thead>
                <tbody className="divide-y divide-slate-100 bg-white">
                    {borrows.map((borrow) => (
                        <tr key={borrow.id} className="hover:bg-slate-50/70">
                            <td className="px-5 py-4"><p className="font-extrabold text-slate-900">{borrow.title}</p>{mode === 'overdue' && <p className="mt-1 text-xs font-bold text-red-600">{borrow.daysOverdue} day{borrow.daysOverdue === 1 ? '' : 's'} overdue</p>}</td>
                            <td className="px-5 py-4 text-slate-500">{borrow.accessionNumber || '—'}</td>
                            <td className="px-5 py-4 text-slate-600">{borrow.issueDate || '—'}</td>
                            <td className="px-5 py-4 font-semibold text-slate-700">{mode === 'history' ? (borrow.returnDate || '—') : (borrow.dueDate || '—')}</td>
                            {mode === 'overdue' && <td className="px-5 py-4 font-bold text-slate-800">{borrow.fine ? `₱${Number(borrow.fine.total).toFixed(2)}` : 'Pending'}</td>}
                            <td className="px-5 py-4 text-right"><Status borrow={borrow} mode={mode} /></td>
                        </tr>
                    ))}
                </tbody>
            </table>
        </div>
    );
}

function Status({ borrow, mode }) {
    if (mode === 'history') return <span className="rounded-md border border-slate-200 bg-slate-50 px-2.5 py-1 text-xs font-bold text-slate-600">Returned</span>;
    const overdue = mode === 'overdue' || borrow.isOverdue;
    return <span className={`rounded-md border px-2.5 py-1 text-xs font-bold ${overdue ? 'border-red-200 bg-red-50 text-red-700' : 'border-emerald-200 bg-emerald-50 text-emerald-700'}`}>{overdue ? 'Overdue' : 'Active'}</span>;
}
