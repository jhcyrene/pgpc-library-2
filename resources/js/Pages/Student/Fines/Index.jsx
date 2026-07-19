import StudentLayout from '../../../Layouts/StudentLayout';

const money = (value) => `₱${Number(value || 0).toFixed(2)}`;

export default function Index({ fineSummary, fines }) {
    const summaries = [
        ['Total assessed', fineSummary.assessed, 'All fine records'],
        ['Payments recorded', fineSummary.paid, 'Received by the library'],
        ['Outstanding balance', fineSummary.outstanding, 'Amount still due'],
    ];

    return (
        <StudentLayout title="Fines & Penalties" active="fines">
            <div className="mx-auto w-full max-w-[1500px] space-y-5">
                <section className="rounded-2xl bg-[#102b70] p-6 text-white shadow-md"><p className="text-xs font-bold uppercase tracking-[0.16em] text-blue-200">My Library</p><h1 className="mt-2 text-3xl font-black">Fines & penalties</h1><p className="mt-2 text-sm text-slate-300">Review assessed fines, outstanding balances, and payments recorded by the library.</p></section>

                <section className="grid gap-4 sm:grid-cols-3">{summaries.map(([label, value, note], index) => <div key={label} className="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm"><p className="text-xs font-bold uppercase tracking-wide text-slate-500">{label}</p><p className={`mt-2 text-2xl font-black ${index === 2 && Number(value) > 0 ? 'text-red-600' : 'text-slate-900'}`}>{money(value)}</p><p className="mt-1 text-xs text-slate-400">{note}</p></div>)}</section>

                <section className="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                    <div className="border-b border-slate-100 bg-slate-50/60 px-5 py-4"><h2 className="font-extrabold text-slate-800">{fines.meta.total ? `Showing ${fines.meta.from}–${fines.meta.to} of ${fines.meta.total}` : 'No fine records'}</h2></div>
                    {fines.data.length ? <FineTable fines={fines.data} /> : <Empty />}
                    <Pagination fines={fines} />
                </section>
            </div>
        </StudentLayout>
    );
}

function FineTable({ fines }) {
    return <div className="overflow-x-auto"><table className="w-full min-w-[55rem] text-left text-sm"><thead className="border-b border-slate-200 bg-slate-50 text-xs uppercase tracking-wide text-slate-500"><tr><th className="px-6 py-3.5">Book details</th><th className="px-6 py-3.5">Fine date</th><th className="px-6 py-3.5 text-right">Assessed</th><th className="px-6 py-3.5 text-right">Paid</th><th className="px-6 py-3.5 text-right">Balance</th><th className="px-6 py-3.5 text-right">Status</th></tr></thead><tbody className="divide-y divide-slate-100">{fines.map((fine) => <FineRow key={fine.id} fine={fine} />)}</tbody></table></div>;
}

function FineRow({ fine }) {
    return <><tr className="hover:bg-slate-50/70"><td className="px-6 py-4"><p className="font-extrabold text-slate-900">{fine.book.title}</p><p className="mt-1 text-xs text-slate-500">Acc. No: {fine.book.accessionNumber || '—'}</p>{(fine.payments.length > 0 || fine.remarks) && <details className="mt-2"><summary className="cursor-pointer text-xs font-bold text-blue-700">Payment details</summary><PaymentDetails fine={fine} /></details>}</td><td className="px-6 py-4 text-slate-600">{fine.fineDate || '—'}</td><td className="px-6 py-4 text-right font-semibold text-slate-800">{money(fine.amount)}</td><td className="px-6 py-4 text-right font-semibold text-emerald-700">{money(fine.totalPaid)}</td><td className={`px-6 py-4 text-right font-extrabold ${fine.isPaid ? 'text-emerald-700' : 'text-red-600'}`}>{money(fine.balance)}</td><td className="px-6 py-4 text-right"><span className={`rounded-full border px-3 py-1 text-[11px] font-extrabold uppercase tracking-wide ${fine.isPaid ? 'border-emerald-200 bg-emerald-50 text-emerald-700' : 'border-red-200 bg-red-50 text-red-700'}`}>{fine.isPaid ? 'Paid' : 'Unpaid'}</span></td></tr></>;
}

function PaymentDetails({ fine }) {
    return <div className="mt-3 w-[28rem] max-w-[70vw] rounded-xl border border-slate-200 bg-white p-3 shadow-sm">{fine.remarks && <p className="mb-3 text-xs italic text-slate-500">{fine.remarks}</p>}{fine.payments.length ? <div className="space-y-2">{fine.payments.map((payment) => <div key={payment.id} className="flex items-start justify-between gap-3 border-t border-slate-100 pt-2 first:border-0 first:pt-0"><div><p className="text-xs font-bold text-slate-700">{payment.date || 'Date unavailable'}</p><p className="text-[11px] text-slate-500">{[payment.method, payment.receiptNumber].filter(Boolean).join(' · ') || 'Payment recorded'}</p></div><span className="text-xs font-extrabold text-emerald-700">{money(payment.amount)}</span></div>)}</div> : <p className="text-xs text-slate-500">No payments recorded.</p>}</div>;
}

function Empty() { return <div className="px-6 py-14 text-center"><div className="text-5xl" aria-hidden="true">✓</div><h2 className="mt-4 text-lg font-extrabold text-slate-900">No fines</h2><p className="mt-2 text-sm text-slate-500">You do not have any fine records.</p></div>; }
function Pagination({ fines }) { if (fines.meta.lastPage <= 1) return null; return <nav className="flex items-center justify-between border-t border-slate-100 bg-slate-50/50 p-4" aria-label="Fines pagination"><a href={fines.links.previous || undefined} className={`rounded-lg px-4 py-2 text-sm font-bold ${fines.links.previous ? 'text-slate-700 hover:bg-white' : 'pointer-events-none text-slate-300'}`}>Previous</a><span className="text-xs font-semibold text-slate-500">Page {fines.meta.currentPage} of {fines.meta.lastPage}</span><a href={fines.links.next || undefined} className={`rounded-lg px-4 py-2 text-sm font-bold ${fines.links.next ? 'text-slate-700 hover:bg-white' : 'pointer-events-none text-slate-300'}`}>Next</a></nav>; }
