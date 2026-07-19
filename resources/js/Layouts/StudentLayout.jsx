import { Head, router, usePage } from '@inertiajs/react';
import { useEffect, useState } from 'react';

import logo from '../../images/hd-pgpc-logo.png';

export default function StudentLayout({ title, active, children }) {
    const { studentPortal } = usePage().props;
    const { student, routes } = studentPortal;
    const [menuOpen, setMenuOpen] = useState(false);
    const [now, setNow] = useState(new Date());

    useEffect(() => {
        const timer = window.setInterval(() => setNow(new Date()), 1000);
        return () => window.clearInterval(timer);
    }, []);

    const logout = () => router.post(routes.logout);

    return (
        <>
            <Head title={title} />
            <div className="flex h-dvh overflow-hidden bg-slate-100">
                {menuOpen && <button type="button" onClick={() => setMenuOpen(false)} className="fixed inset-0 z-40 bg-slate-950/50 lg:hidden" aria-label="Close student navigation" />}
                <aside className={`fixed inset-y-0 left-0 z-50 flex w-72 flex-col bg-[#0b1f4f] text-white transition-transform lg:static lg:w-64 lg:translate-x-0 ${menuOpen ? 'translate-x-0' : '-translate-x-full'}`}>
                    <div className="flex h-[60px] items-center justify-between border-b border-white/10 px-5"><a href={routes.dashboard} className="flex items-center gap-3"><img src={logo} alt="PGPC logo" className="h-9 w-9 rounded-full bg-white object-cover" /><span><span className="block text-sm font-extrabold">PGPC Library</span><span className="block text-[10px] uppercase tracking-wider text-blue-200">Student Portal</span></span></a><button type="button" onClick={() => setMenuOpen(false)} className="text-xl lg:hidden" aria-label="Close menu">×</button></div>
                    <nav className="flex-1 space-y-1 overflow-y-auto p-4" aria-label="Student portal">
                        <NavLink href={routes.dashboard} label="Dashboard" active={active === 'dashboard'} />
                        <p className="px-3 pb-1 pt-5 text-[10px] font-bold uppercase tracking-[0.16em] text-blue-200/60">My Library</p>
                        <NavLink href={routes.currentBorrows} label="Current Borrows" active={active === 'current-borrows'} />
                        <NavLink href={routes.borrowHistory} label="Borrow History" active={active === 'history'} />
                        <NavLink href={routes.overdue} label="Overdue Items" active={active === 'overdue'} />
                        <NavLink href={routes.reservations} label="Reservations" active={active === 'reservations'} />
                        <NavLink href={routes.savedItems} label="Saved Items" active={active === 'saved'} />
                        <NavLink href={routes.fines} label="Fines & Penalties" active={active === 'fines'} />
                        <p className="px-3 pb-1 pt-5 text-[10px] font-bold uppercase tracking-[0.16em] text-blue-200/60">Discover</p>
                        <NavLink href={routes.catalog} label="Browse Catalog" active={false} />
                    </nav>
                    <div className="border-t border-white/10 p-4"><div className="flex items-center gap-3"><a href={routes.profile} className="min-w-0 flex-1 rounded-xl p-2 hover:bg-white/10"><p className="truncate text-sm font-bold">{student.firstName} {student.lastName}</p><p className="truncate text-[10px] text-slate-400">{student.studentId || 'View profile'}</p></a><a href={routes.accountSettings} className="rounded-lg p-2 text-slate-300 hover:bg-white/10" aria-label="Account settings">⚙</a><button type="button" onClick={logout} className="rounded-lg p-2 text-slate-300 hover:bg-white/10" aria-label="Log out">↪</button></div></div>
                </aside>

                <div className="flex min-w-0 flex-1 flex-col">
                    <header className="flex h-[60px] shrink-0 items-center justify-between border-b border-slate-200 bg-white px-4 md:grid md:grid-cols-3 md:px-6">
                        <div className="flex items-center gap-3"><button type="button" onClick={() => setMenuOpen(true)} className="rounded-md p-2 text-slate-600 hover:bg-slate-100 lg:hidden" aria-label="Open student navigation">☰</button><div className="hidden text-sm sm:block"><span className="text-slate-500">Student</span><span className="mx-1">›</span><span className="font-bold capitalize text-slate-800">{title}</span></div></div>
                        <form action={routes.catalog} method="GET" className="relative hidden w-full max-w-md justify-self-center md:block"><input name="q" placeholder="Search the catalog..." className="w-full rounded-lg border border-slate-200 bg-slate-50 py-2 pl-3 pr-20 text-sm outline-none focus:border-[#102b70]" /><button className="absolute right-1.5 top-1/2 -translate-y-1/2 rounded-md bg-[#102b70] px-3 py-1.5 text-xs font-medium text-white">Search</button></form>
                        <div className="flex items-center justify-end gap-4"><a href={routes.catalog} className="text-slate-500 md:hidden" aria-label="Search catalog">⌕</a><div className="hidden text-right leading-tight sm:block"><span className="block text-sm font-bold text-slate-800">{now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', second: '2-digit' })}</span><span className="block text-[10px] uppercase tracking-wider text-slate-500">{now.toLocaleDateString([], { weekday: 'short', month: 'short', day: 'numeric' })}</span></div><a href={routes.overdue} className="text-slate-500" aria-label="View overdue items">🔔</a></div>
                    </header>
                    <main className="min-w-0 flex-1 overflow-y-auto p-4 md:p-6">{children}</main>
                </div>
            </div>
        </>
    );
}

function NavLink({ href, label, active }) {
    return <a href={href} className={`flex items-center rounded-xl px-3 py-2.5 text-sm font-semibold transition ${active ? 'bg-[#fcc719] text-[#102b70]' : 'text-blue-50 hover:bg-white/10'}`}>{label}</a>;
}
