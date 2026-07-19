import { router, usePage } from '@inertiajs/react';
import { useEffect, useState } from 'react';

import brandLogo from '../../images/pgpc-logo.jpg';
import footerLogo from '../../images/logo.jfif';

export default function PublicLayout({ children, routes, active = 'home' }) {
    const { auth } = usePage().props;
    const [mobileMenuOpen, setMobileMenuOpen] = useState(false);
    const [scrolled, setScrolled] = useState(false);

    useEffect(() => {
        const updateScrolled = () => setScrolled(window.scrollY > 20);
        updateScrolled();
        window.addEventListener('scroll', updateScrolled, { passive: true });
        return () => window.removeEventListener('scroll', updateScrolled);
    }, []);

    const logout = () => {
        setMobileMenuOpen(false);
        router.post(routes.logout);
    };

    return (
        <div className="flex min-h-dvh flex-col bg-base-100 text-base-content">
            <header className={`fixed z-50 w-full transition-all duration-300 ${scrolled ? 'bg-[#102b70] py-3 shadow-md' : 'bg-transparent py-5'}`}>
                <div className="container mx-auto flex items-center justify-between px-6 md:px-12">
                    <a href={routes.home} className="flex items-center gap-3" aria-label="PGPC Library home">
                        <span className="flex h-10 w-10 items-center justify-center overflow-hidden rounded-full bg-white shadow-sm">
                            <img src={brandLogo} alt="PGPC Logo" className="h-full w-full object-cover" />
                        </span>
                        <span className="hidden text-lg font-bold text-white sm:block">
                            Padre Garcia Polytechnic College
                        </span>
                    </a>

                    <nav className="hidden items-center gap-8 md:flex" aria-label="Primary navigation">
                        <a href={routes.home} className={`font-medium transition-colors hover:text-[#fcc719] ${active === 'home' ? 'text-[#fcc719]' : 'text-gray-100'}`}>Home</a>
                        <a href={routes.opac} className={`font-medium transition-colors hover:text-[#fcc719] ${active === 'opac' ? 'text-[#fcc719]' : 'text-gray-100'}`}>OPAC</a>
                        <a href="#contact" className="font-medium text-gray-100 transition-colors hover:text-[#fcc719]">Contact</a>
                        <div className="flex items-center gap-3">
                            {auth?.user ? (
                                <>
                                    <a href={auth.dashboardUrl} className="rounded-full bg-[#fcc719] px-5 py-2.5 font-bold text-[#102b70] transition hover:bg-[#ffd84c] hover:shadow-md">
                                        Dashboard
                                    </a>
                                    <button type="button" onClick={logout} className="cursor-pointer rounded-full border border-white/20 px-5 py-2.5 font-semibold text-white transition hover:border-white hover:bg-white hover:text-[#102b70]">
                                        Log out
                                    </button>
                                </>
                            ) : (
                                <>
                                    <a href={routes.login} className="rounded-full border border-white/20 px-5 py-2.5 font-semibold text-white transition hover:border-white hover:bg-white hover:text-[#102b70]">Log in</a>
                                    <a href={routes.register} className="rounded-full bg-[#fcc719] px-5 py-2.5 font-bold text-[#102b70] transition hover:bg-[#ffd84c] hover:shadow-md">Register</a>
                                </>
                            )}
                        </div>
                    </nav>

                    <button
                        type="button"
                        className="btn btn-circle btn-ghost text-white md:hidden"
                        aria-expanded={mobileMenuOpen}
                        aria-controls="mobile-navigation"
                        aria-label="Toggle navigation"
                        onClick={() => setMobileMenuOpen((open) => !open)}
                    >
                        <svg className="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d={mobileMenuOpen ? 'M6 18L18 6M6 6l12 12' : 'M4 6h16M4 12h16M4 18h16'} />
                        </svg>
                    </button>
                </div>

                {mobileMenuOpen && (
                    <nav id="mobile-navigation" className="absolute left-0 top-full flex w-full flex-col gap-4 bg-[#102b70]/95 px-6 py-4 shadow-lg backdrop-blur-md md:hidden" aria-label="Mobile navigation">
                        <a href={routes.home} className="border-b border-white/10 py-2 font-bold text-white">Home</a>
                        <a href={routes.opac} className="border-b border-white/10 py-2 font-medium text-gray-300 hover:text-[#fcc719]">OPAC</a>
                        <a href="#categories" onClick={() => setMobileMenuOpen(false)} className="border-b border-white/10 py-2 font-medium text-gray-300 hover:text-[#fcc719]">Categories</a>
                        <a href="#about" onClick={() => setMobileMenuOpen(false)} className="border-b border-white/10 py-2 font-medium text-gray-300 hover:text-[#fcc719]">About</a>
                        <a href="#contact" onClick={() => setMobileMenuOpen(false)} className="border-b border-white/10 py-2 font-medium text-gray-300 hover:text-[#fcc719]">Contact</a>
                        <div className="mt-2 flex flex-col gap-3">
                            {auth?.user ? (
                                <>
                                    <a href={auth.dashboardUrl} className="rounded-xl bg-[#fcc719] px-5 py-3 text-center font-bold text-[#102b70]">Dashboard</a>
                                    <button type="button" onClick={logout} className="rounded-xl border border-white/20 px-5 py-3 font-semibold text-white">Log out</button>
                                </>
                            ) : (
                                <>
                                    <a href={routes.login} className="rounded-xl border border-white/20 px-5 py-3 text-center font-semibold text-white">Log in</a>
                                    <a href={routes.register} className="rounded-xl bg-[#fcc719] px-5 py-3 text-center font-bold text-[#102b70]">Register</a>
                                </>
                            )}
                        </div>
                    </nav>
                )}
            </header>

            <main className="w-full flex-grow">{children}</main>

            <footer id="contact" className="bg-gray-900 py-16 text-gray-300">
                <div className="container mx-auto px-6 md:px-12">
                    <div className="grid grid-cols-1 gap-12 md:grid-cols-2 lg:grid-cols-4">
                        <div>
                            <a href={routes.home} className="mb-6 flex items-center gap-3">
                                <span className="flex h-10 w-10 items-center justify-center overflow-hidden rounded-full bg-white">
                                    <img src={footerLogo} alt="PGPC Logo" className="h-full w-full object-cover" />
                                </span>
                                <span className="text-xl font-bold text-white">PGPC Library</span>
                            </a>
                            <p className="text-sm leading-relaxed text-gray-400">Taga-PGPC Ako: Matalino, Disiplinado, Mabuting Tao, Ipinagmamalaki ko!</p>
                        </div>
                        <FooterLinks title="Quick Links" links={[
                            ['Home', routes.home],
                            ['About Us', `${routes.home}#about`],
                            ['OPAC Search', routes.opac],
                            ['New Arrivals', `${routes.opac}?sort=newest`],
                            ['Student Portal', routes.login],
                        ]} />
                        <FooterLinks title="Top Categories" links={[
                            ['Computer Science', `${routes.opac}?category=Computer%20Science`],
                            ['Engineering', `${routes.opac}?category=Engineering`],
                            ['Education', `${routes.opac}?category=Education`],
                            ['Business & Accountancy', `${routes.opac}?category=Business%20%26%20Accountancy`],
                            ['General References', `${routes.opac}?category=General%20References`],
                        ]} />
                        <div>
                            <h2 className="mb-6 text-lg font-bold text-white">Contact Us</h2>
                            <ul className="space-y-4 text-sm">
                                <li>Poblacion, Padre Garcia, Batangas</li>
                                <li><a href="tel:+63435157722" className="hover:text-[#fcc719]">(043) 515 7722</a></li>
                                <li><a href="mailto:info@padregarcia.gov.ph" className="hover:text-[#fcc719]">info@padregarcia.gov.ph</a></li>
                                <li><a href="https://www.padregarcia.gov.ph/government/padre-garcia-polytechnic-college" target="_blank" rel="noreferrer" className="hover:text-[#fcc719] hover:underline">www.padregarcia.gov.ph</a></li>
                            </ul>
                        </div>
                    </div>
                    <div className="mt-16 border-t border-gray-800 pt-8 text-center text-sm text-gray-500">
                        <p>&copy; 2026 Padre Garcia Polytechnic College Library. All rights reserved.</p>
                    </div>
                </div>
            </footer>
        </div>
    );
}

function FooterLinks({ title, links }) {
    return (
        <div>
            <h2 className="mb-6 text-lg font-bold text-white">{title}</h2>
            <ul className="space-y-3 text-sm">
                {links.map(([label, href]) => (
                    <li key={label}><a href={href} className="transition-colors hover:text-[#fcc719]">{label}</a></li>
                ))}
            </ul>
        </div>
    );
}
