import { usePage } from '@inertiajs/react';

export default function RecoveryCard({ title, description, backUrl, backLabel = 'Back', children }) {
    const { flash } = usePage().props;

    return (
        <div>
            {backUrl && <a href={backUrl} className="mb-8 inline-flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-[#102b70]">&larr; {backLabel}</a>}
            <div className="mb-6 flex justify-center"><span className="grid h-16 w-16 place-items-center rounded-full bg-blue-50 text-3xl text-[#102b70] shadow-sm" aria-hidden="true">🔐</span></div>
            <div className="mb-8 text-center"><h2 className="text-2xl font-bold text-slate-800 sm:text-3xl">{title}</h2><p className="mt-2 text-sm leading-6 text-slate-500">{description}</p></div>
            {flash?.status && <div role="status" className="mb-5 rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-700">{flash.status}</div>}
            {children}
        </div>
    );
}
