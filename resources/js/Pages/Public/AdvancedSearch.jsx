import { Head } from '@inertiajs/react';

import PublicLayout from '../../Layouts/PublicLayout';
import backgroundImage from '../../../images/pgpc-ng.png';

const searchableFields = [
    ['title', 'Title', 'Search by title...'],
    ['author', 'Personal or Corporate Author', 'Search by author...'],
    ['subject', 'Subjects', 'Search by subject...'],
    ['call_number', 'Call Number(s)', 'Search by call number...'],
];

export default function AdvancedSearch({ routes }) {
    return (
        <PublicLayout routes={routes} active="opac">
            <Head title="Advanced Search" />
            <section className="relative overflow-hidden bg-[#102b70] pb-28 pt-32 sm:pb-36 sm:pt-40">
                <div className="absolute inset-0 bg-cover bg-center opacity-[0.05]" style={{ backgroundImage: `url(${backgroundImage})` }} />
                <div className="container relative z-10 mx-auto px-5 text-center sm:px-6 md:px-12"><p className="text-xs font-bold uppercase tracking-[0.2em] text-[#fcc719]">Advanced Search</p><h1 className="mt-3 text-3xl font-bold text-white sm:text-5xl">Find Specific Resources</h1><p className="mx-auto mt-5 max-w-2xl text-base leading-7 text-blue-100 sm:text-lg">Use the fields below to perform a highly targeted search across the PGPC Library catalog.</p></div>
            </section>

            <section className="relative z-20 -mt-20 pb-20">
                <div className="container mx-auto px-5 sm:px-6 md:px-12">
                    <div className="mx-auto w-full rounded-3xl border border-slate-100 bg-white p-6 shadow-xl sm:p-10">
                        <form action={routes.opac} method="GET">
                            <div className="sticky top-16 z-30 -mx-6 flex flex-col gap-4 border-b border-slate-100 bg-white px-6 pb-5 pt-2 sm:-mx-10 sm:flex-row sm:items-center sm:justify-between sm:px-10">
                                <Actions routes={routes} />
                                <label className="flex items-center gap-3 text-xs font-bold uppercase tracking-wider text-slate-500">Max Records<select name="limit" defaultValue="50" className="rounded-xl border border-slate-200 bg-slate-50 px-4 py-2 text-sm font-semibold text-slate-700"><option>10</option><option>20</option><option>50</option><option>100</option></select></label>
                            </div>

                            <div className="mt-6 grid grid-cols-1 gap-x-8 gap-y-5 lg:grid-cols-2">
                                <div className="space-y-1.5 lg:col-span-2"><label htmlFor="keywords" className="block text-sm font-bold text-slate-700">Key Words</label><input id="keywords" name="q" className={inputClass} placeholder="Enter keywords..." /><ExactCheckbox name="use_operators" label="Use my search operators" /></div>
                                <div className="my-1 h-px bg-slate-100 lg:col-span-2" />
                                {searchableFields.map(([name, label, placeholder]) => <div key={name} className="space-y-1.5"><label htmlFor={name} className="block text-sm font-bold text-slate-700">{label}</label><input id={name} name={name} className={inputClass} placeholder={placeholder} /><ExactCheckbox name={`${name}_exact`} label="Match exactly as pasted/entered" /></div>)}
                                <div className="my-1 h-px bg-slate-100 lg:col-span-2" />
                                <div className="space-y-1.5"><label htmlFor="format" className="block text-sm font-bold text-slate-700">Format</label><select id="format" name="format" className={inputClass}><option value="">All Formats</option><option value="book">Book</option><option value="journal">Journal</option><option value="dvd">DVD / CD</option><option value="map">Map</option></select></div>
                                <div className="space-y-1.5"><span className="block text-sm font-bold text-slate-700">Publication Year</span><div className="flex items-center gap-3"><input type="number" name="year_from" placeholder="From" className={inputClass} /><span className="font-bold text-slate-400">to</span><input type="number" name="year_to" placeholder="To" className={inputClass} /></div></div>
                                <div className="pt-2 lg:col-span-2"><ExactCheckbox name="exclude_on_order" label="Exclude titles on order" /></div>
                            </div>

                            <div className="mt-8 border-t border-slate-100 pt-6"><Actions routes={routes} primaryGold /></div>
                        </form>
                    </div>
                </div>
            </section>
        </PublicLayout>
    );
}

const inputClass = 'w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-medium text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-[#102b70] focus:ring-2 focus:ring-blue-100';

function ExactCheckbox({ name, label }) {
    return <label className="inline-flex cursor-pointer items-center gap-2"><input type="checkbox" name={name} className="h-4 w-4 rounded border-slate-300 accent-[#102b70]" /><span className="text-xs font-semibold text-slate-500">{label}</span></label>;
}

function Actions({ routes, primaryGold = false }) {
    return <div className="flex flex-wrap items-center gap-2"><button type="submit" className={`min-h-10 rounded-xl px-5 py-2 text-sm font-bold ${primaryGold ? 'bg-[#fcc719] text-[#102b70]' : 'bg-[#102b70] text-white'}`}>Submit Search</button><button type="reset" className="min-h-10 rounded-xl border border-slate-200 bg-slate-50 px-5 py-2 text-sm font-bold text-slate-600">Clear</button><a href={routes.opac} className="inline-flex min-h-10 items-center rounded-xl border border-slate-200 bg-white px-5 py-2 text-sm font-bold text-slate-600">Exit Catalog</a></div>;
}
