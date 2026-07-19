import { useForm, usePage } from '@inertiajs/react';

import StaffLayout from '../../../Layouts/StaffLayout';

export default function Administrator({ systemSettings }) {
    const { flash } = usePage().props;
    const form = useForm({
        default_borrow_days: systemSettings.defaultBorrowDays,
        daily_fine_amount: Number(systemSettings.dailyFineAmount).toFixed(2),
    });
    const submit = (event) => {
        event.preventDefault();
        form.post(systemSettings.updateUrl, { preserveScroll: true });
    };

    return <StaffLayout title="System Settings" active="settings"><div className="mx-auto w-full max-w-5xl space-y-5"><section className="rounded-2xl bg-[#102b70] p-6 text-white shadow-md"><p className="text-xs font-bold uppercase tracking-[0.16em] text-blue-200">Administrator</p><h1 className="mt-2 text-3xl font-black">System settings</h1><p className="mt-2 text-sm text-slate-300">Configure library circulation rules and operational parameters.</p></section>{flash?.success && <div role="status" className="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-bold text-emerald-700">{flash.success}</div>}{flash?.error && <div role="alert" className="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-bold text-red-700">{flash.error}</div>}<section className="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm"><header className="flex items-center gap-4 border-b border-slate-100 bg-slate-50/60 px-6 py-5"><div className="grid h-11 w-11 place-items-center rounded-full bg-blue-50 text-xl text-[#102b70]">⚙</div><div><h2 className="text-lg font-extrabold text-slate-900">Circulation rules</h2><p className="mt-0.5 text-xs text-slate-500">Manage borrowing duration and overdue penalties.</p></div></header><form onSubmit={submit} className="space-y-7 p-6 md:p-8"><div className="grid gap-6 md:grid-cols-2"><NumberField label="Default borrow duration" name="default_borrow_days" value={form.data.default_borrow_days} min="1" step="1" suffix="Days" error={form.errors.default_borrow_days} onChange={(value) => form.setData('default_borrow_days', value)} description="Number of days a book can be borrowed before it becomes overdue." /><NumberField label="Daily fine amount" name="daily_fine_amount" value={form.data.daily_fine_amount} min="0" step="0.01" prefix="₱" error={form.errors.daily_fine_amount} onChange={(value) => form.setData('daily_fine_amount', value)} description="Amount charged for each day a borrowed book is overdue." /></div><div className="rounded-xl border border-amber-100 bg-amber-50 p-4 text-sm leading-relaxed text-amber-800"><strong>Operational impact:</strong> Changes apply to new checkout due dates and newly calculated overdue fines. Existing records are not rewritten.</div><div className="flex justify-end border-t border-slate-100 pt-6"><button type="submit" disabled={form.processing} className="rounded-xl bg-[#102b70] px-7 py-3 text-sm font-bold text-white disabled:opacity-60">{form.processing ? 'Saving…' : 'Save settings'}</button></div></form></section></div></StaffLayout>;
}

function NumberField({ label, name, value, min, step, prefix, suffix, error, onChange, description }) {
    return <div><label htmlFor={name} className="mb-1.5 block text-sm font-bold text-slate-700">{label}</label><div className="relative">{prefix && <span className="absolute left-4 top-1/2 -translate-y-1/2 font-bold text-slate-400">{prefix}</span>}<input id={name} type="number" value={value} min={min} step={step} required onChange={(event) => onChange(event.target.value)} className={`w-full rounded-xl border border-slate-200 bg-slate-50 py-3 text-sm outline-none focus:border-[#102b70] ${prefix ? 'pl-9 pr-3' : suffix ? 'pl-3 pr-16' : 'px-3'}`} />{suffix && <span className="absolute right-4 top-1/2 -translate-y-1/2 text-xs font-bold text-slate-400">{suffix}</span>}</div>{error && <p className="mt-1 text-xs font-semibold text-red-600">{error}</p>}<p className="mt-2 text-xs leading-relaxed text-slate-500">{description}</p></div>;
}
