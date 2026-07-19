import { Head } from '@inertiajs/react';

import backgroundImage from '../../images/pgpc-ng.png';
import logo from '../../images/hd-pgpc-logo.png';

export default function AuthLayout({
    title,
    routes,
    formSide = 'right',
    accessLabel = 'Authorized personnel access',
    headline = 'Manage knowledge.',
    highlight = 'Empower learning.',
    description = 'A secure workspace for library operations, circulation, cataloging, and member services.',
    features = ['Cataloging', 'Members', 'Reports'],
    formWidth = 'default',
    children,
}) {
    const formFirst = formSide === 'left';

    return (
        <>
            <Head title={title} />
            <main className={`relative min-h-dvh overflow-hidden bg-slate-100 lg:grid lg:h-dvh ${formFirst ? 'lg:grid-cols-[minmax(440px,0.92fr)_minmax(0,1.08fr)]' : 'lg:grid-cols-[minmax(0,1.08fr)_minmax(440px,0.92fr)]'}`}>
                <section className={`relative hidden min-h-dvh overflow-hidden bg-[#102b70] lg:flex lg:h-dvh lg:flex-col lg:justify-between lg:p-12 xl:p-16 ${formFirst ? 'lg:order-2' : 'lg:order-1'}`}>
                    <img src={backgroundImage} alt="" className="absolute inset-0 h-full w-full object-cover" />
                    <div className="absolute inset-0 bg-gradient-to-br from-[#071943]/95 via-[#102b70]/88 to-[#102b70]/70" />
                    <div className="absolute -left-24 bottom-20 h-80 w-80 rounded-full border border-white/10" />
                    <div className="absolute -left-8 bottom-36 h-48 w-48 rounded-full border border-[#fcc719]/25" />

                    <a href={routes.home} className="relative z-10 inline-flex w-fit items-center gap-3 text-white">
                        <span className="grid h-12 w-12 place-items-center overflow-hidden rounded-full bg-white shadow-lg ring-4 ring-white/10">
                            <img src={logo} alt="PGPC logo" className="h-full w-full object-cover" />
                        </span>
                        <span>
                            <span className="block text-xs font-bold uppercase tracking-[0.18em] text-[#fcc719]">PGPC Library System</span>
                            <span className="block text-base font-semibold">Padre Garcia Polytechnic College</span>
                        </span>
                    </a>

                    <div className="relative z-10 max-w-2xl pb-8">
                        <div className="mb-7 inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/10 px-4 py-2 text-sm font-semibold text-white backdrop-blur-sm">
                            <span className="h-2 w-2 rounded-full bg-[#fcc719]" />
                            {accessLabel}
                        </div>
                        <h1 className="max-w-xl text-5xl font-bold leading-[1.08] tracking-tight text-white xl:text-6xl">
                            {headline}<br /><span className="text-[#fcc719]">{highlight}</span>
                        </h1>
                        <p className="mt-6 max-w-xl text-lg leading-8 text-blue-100/90">{description}</p>
                        <div className="mt-10 grid max-w-xl grid-cols-3 gap-3">
                            {features.map((feature) => (
                                <div key={feature} className="rounded-2xl border border-white/10 bg-white/10 p-4 backdrop-blur-sm">
                                    <FeatureIcon />
                                    <p className="text-sm font-semibold text-white">{feature}</p>
                                </div>
                            ))}
                        </div>
                    </div>
                    <p className="relative z-10 text-xs text-blue-100/65">&copy; {new Date().getFullYear()} PGPC Library. All rights reserved.</p>
                </section>

                <section className={`relative flex min-h-dvh flex-col overflow-y-auto bg-slate-50 px-4 py-8 sm:px-8 lg:h-dvh lg:min-h-0 lg:px-12 ${formFirst ? 'lg:order-1' : 'lg:order-2'}`}>
                    <div className="absolute inset-x-0 top-0 h-1.5 bg-gradient-to-r from-[#102b70] via-[#fcc719] to-[#102b70] lg:hidden" />
                    <div className="absolute right-0 top-0 h-64 w-64 rounded-bl-full bg-blue-50/80" />
                    <div className={`relative z-10 m-auto w-full ${formWidth === 'wide' ? 'max-w-2xl' : 'max-w-md'}`}>
                        <div className="mb-8 flex items-center justify-between lg:hidden">
                            <a href={routes.home} className="inline-flex items-center gap-2 text-sm font-bold text-[#102b70] hover:text-[#0b225e]">
                                <span aria-hidden="true">&larr;</span> Home
                            </a>
                            <div className="flex items-center gap-2.5">
                                <span className="text-right">
                                    <span className="block text-[10px] font-bold uppercase leading-none tracking-wider text-[#102b70]">PGPC Library</span>
                                    <span className="mt-0.5 block text-[8px] font-semibold uppercase leading-none tracking-widest text-slate-500">System</span>
                                </span>
                                <img src={logo} alt="PGPC logo" className="h-10 w-10 rounded-full shadow-sm ring-2 ring-[#102b70]/10" />
                            </div>
                        </div>
                        {children}
                    </div>
                </section>
            </main>
        </>
    );
}

function FeatureIcon() {
    return (
        <svg className="mb-3 h-6 w-6 text-[#fcc719]" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.8" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5A8.5 8.5 0 003 6.253v13A8.5 8.5 0 017.5 18c1.746 0 3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5A8.5 8.5 0 0121 6.253v13A8.5 8.5 0 0016.5 18c-1.746 0-3.332.477-4.5 1.253" />
        </svg>
    );
}
