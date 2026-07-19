import { Head } from '@inertiajs/react';

import PublicLayout from '../../Layouts/PublicLayout';
import heroImage from '../../../images/pgpc-ng.png';

const services = [
    ['Search the Catalog', 'Find books, journals, and resources by title, author, or subject.'],
    ['Check Availability', 'See which items are available before your visit to the library.'],
    ['Reserve Items', 'Place holds on books and materials you need for your studies.'],
    ['View Transactions', 'Track your borrowing history, due dates, and return status.'],
];

const categories = [
    ['Computer Science', 'Programming, algorithms, software, and computing resources.'],
    ['Information Technology', 'Networking, systems, databases, and information management.'],
    ['Mathematics', 'Algebra, statistics, calculus, and applied mathematics.'],
    ['Science', 'Natural sciences, laboratory references, and scientific studies.'],
    ['Literature', 'Fiction, language, literary works, and cultural studies.'],
    ['Research', 'Theses, academic writing, research methods, and references.'],
];

export default function Home({ routes }) {
    return (
        <PublicLayout routes={routes}>
            <Head title="Home">
                <meta name="description" content="Access the PGPC Library System to search the catalog, check availability, reserve library resources, and review borrow transactions." />
            </Head>

            <section className="relative flex min-h-[100dvh] w-full items-center justify-center overflow-hidden bg-[#102b70] pb-16 pt-24 lg:pb-20 lg:pt-28">
                <div className="absolute inset-0 bg-cover bg-center" style={{ backgroundImage: `url(${heroImage})` }} aria-hidden="true" />
                <div className="absolute inset-0 bg-gradient-to-br from-[#071943]/95 via-[#102b70]/88 to-[#102b70]/70" aria-hidden="true" />
                <div className="pointer-events-none absolute -right-24 -top-20 h-80 w-80 rounded-full border border-white/10" />
                <div className="pointer-events-none absolute -left-12 bottom-12 h-64 w-64 rounded-full border border-[#fcc719]/25" />

                <div className="container relative z-10 mx-auto px-6 md:px-12">
                    <div className="grid min-w-0 items-center gap-12 lg:grid-cols-[minmax(0,1.2fr)_minmax(320px,0.8fr)] lg:gap-16 xl:gap-20">
                        <div className="w-full max-w-2xl min-w-0 text-center lg:text-left">
                            <div className="mb-5 inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/10 px-4 py-2 text-xs font-bold uppercase tracking-[0.18em] text-white backdrop-blur-sm">
                                <BookIcon /> PGPC Library
                            </div>
                            <h1 className="text-4xl font-bold leading-[1.08] tracking-tight text-white drop-shadow-md sm:text-5xl lg:text-6xl">
                                PGPC Library <span className="text-[#fcc719]">System</span>
                            </h1>
                            <p className="mx-auto mt-6 max-w-2xl text-base font-medium leading-7 text-blue-50/95 sm:text-lg lg:mx-0">
                                Search the catalog, check book availability, reserve library resources, and keep track of your borrow transactions in one place.
                            </p>
                            <div className="mt-8 flex w-full flex-col items-stretch justify-center gap-3 sm:w-auto sm:flex-row sm:items-center lg:justify-start">
                                <a href={routes.opac} className="btn h-auto min-h-12 w-full rounded-full border-none bg-[#fcc719] px-6 py-3 font-bold text-[#102b70] shadow-md transition hover:-translate-y-0.5 hover:bg-[#ffd84c] sm:w-auto">
                                    Browse Catalog
                                </a>
                                <a href={routes.login} className="btn h-auto min-h-12 w-full rounded-full border-2 border-white/70 bg-white/10 px-6 py-3 font-bold text-white backdrop-blur-sm transition hover:-translate-y-0.5 hover:border-[#fcc719] hover:bg-[#fcc719] hover:text-[#102b70] sm:w-auto">
                                    Student Login
                                </a>
                            </div>
                        </div>

                        <div id="about" className="min-w-0 scroll-mt-28 lg:w-full lg:justify-self-end">
                            <div className="overflow-hidden rounded-2xl border border-white/10 bg-white/10 shadow-xl backdrop-blur-md">
                                <div className="flex items-center justify-between border-b border-white/10 px-5 py-4 sm:px-6">
                                    <h2 className="text-lg font-bold text-white sm:text-xl">Library Services</h2>
                                    <span className="rounded-full bg-[#fcc719] px-3 py-1 text-[10px] font-bold uppercase tracking-wider text-[#102b70]">Student Services</span>
                                </div>
                                <div className="divide-y divide-white/[0.06] px-5 sm:px-6">
                                    {services.map(([title, description]) => (
                                        <div key={title} className="flex items-start gap-4 py-4">
                                            <span className="mt-0.5 grid h-10 w-10 shrink-0 place-items-center rounded-xl bg-white/10 text-[#fcc719]"><BookIcon /></span>
                                            <div className="min-w-0">
                                                <h3 className="text-sm font-bold text-white">{title}</h3>
                                                <p className="mt-0.5 text-xs leading-relaxed text-blue-100/70">{description}</p>
                                            </div>
                                        </div>
                                    ))}
                                </div>
                                <div className="border-t border-white/10 px-5 py-4 sm:px-6">
                                    <a href={routes.opac} className="flex w-full items-center justify-center gap-2 rounded-xl bg-white/10 px-4 py-2.5 text-sm font-bold text-white transition hover:bg-[#fcc719] hover:text-[#102b70]">Browse Catalog <ArrowIcon /></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section id="categories" aria-labelledby="categories-heading" className="relative scroll-mt-20 overflow-hidden border-y border-slate-200/70 bg-[#f7f9fc] py-12 sm:py-14 lg:py-16">
                <div className="container relative mx-auto px-6 md:px-12">
                    <div className="grid gap-6 border-b border-slate-200/80 pb-8 lg:grid-cols-[minmax(0,1fr)_auto] lg:items-end">
                        <div className="max-w-2xl">
                            <p className="flex items-center gap-3 text-xs font-extrabold uppercase tracking-[0.2em] text-[#b98b00]"><span className="h-0.5 w-8 rounded-full bg-[#fcc719]" />About Our Collections</p>
                            <h2 id="categories-heading" className="mt-3 text-3xl font-extrabold tracking-tight text-[#102b70] sm:text-4xl">Explore by Category</h2>
                            <p className="mt-3 max-w-xl text-sm font-medium leading-6 text-slate-600 sm:text-base">Browse resources by subject, then continue your search through the PGPC Library catalog.</p>
                        </div>
                        <a href={routes.opac} className="inline-flex w-fit items-center gap-2 rounded-full bg-[#102b70] px-5 py-2.5 text-sm font-bold text-white shadow-sm transition hover:-translate-y-0.5 hover:bg-[#0b225e]">View all resources <ArrowIcon /></a>
                    </div>

                    <div className="mt-8 grid auto-rows-fr grid-cols-1 gap-4 sm:grid-cols-2 sm:gap-5 lg:grid-cols-3">
                        {categories.map(([name, description], index) => (
                            <a key={name} href={`${routes.opac}?category=${encodeURIComponent(name)}`} className="group relative flex min-h-[13rem] flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition duration-300 hover:-translate-y-1 hover:border-[#102b70]/25 hover:shadow-xl sm:p-6">
                                <div className="absolute inset-x-0 top-0 h-[3px] bg-gradient-to-r from-[#fcc719] via-[#f8d75f] to-[#fcc719]" />
                                <div className="flex flex-1 flex-col">
                                    <div className="flex items-start justify-between gap-4">
                                        <div className="flex items-center gap-4">
                                            <span className="grid h-11 w-11 place-items-center rounded-xl bg-[#102b70]/[0.045] text-[#102b70] transition group-hover:bg-[#102b70] group-hover:text-[#fcc719]"><BookIcon /></span>
                                            <h3 className="text-base font-extrabold leading-snug text-slate-800 group-hover:text-[#102b70]">{name}</h3>
                                        </div>
                                        <span className="pt-1 text-xs font-extrabold tracking-[0.16em] text-slate-300">{String(index + 1).padStart(2, '0')}</span>
                                    </div>
                                    <p className="mt-4 flex-1 text-sm font-medium leading-6 text-slate-500">{description}</p>
                                </div>
                                <div className="mt-5 flex items-center justify-between border-t border-slate-100 pt-4">
                                    <span className="text-xs font-bold uppercase tracking-[0.12em] text-slate-400">Browse subject</span>
                                    <span className="grid h-8 w-8 place-items-center rounded-full bg-slate-100 text-[#102b70] group-hover:bg-[#fcc719]"><ArrowIcon /></span>
                                </div>
                            </a>
                        ))}
                    </div>
                </div>
            </section>
        </PublicLayout>
    );
}

function BookIcon() {
    return <svg className="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5A8.5 8.5 0 003 6.253v13A8.5 8.5 0 017.5 18c1.746 0 3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5A8.5 8.5 0 0121 6.253v13A8.5 8.5 0 0016.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>;
}

function ArrowIcon() {
    return <svg className="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2.5" d="M9 5l7 7-7 7" /></svg>;
}
