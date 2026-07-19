import { useForm } from '@inertiajs/react';
import { useState } from 'react';

import AuthLayout from '../../Layouts/AuthLayout';

const initialData = {
    student_id_number: '',
    first_name: '',
    middle_name: '',
    last_name: '',
    email: '',
    contact_num: '',
    program: '',
    year_level: '',
    username: '',
    password: '',
    password_confirmation: '',
    terms: false,
};

export default function Register({ routes }) {
    const { data, setData, post, processing, errors, clearErrors } = useForm(initialData);
    const [visiblePasswords, setVisiblePasswords] = useState({ password: false, password_confirmation: false });
    const [legalDocument, setLegalDocument] = useState(null);

    const submit = (event) => {
        event.preventDefault();
        post(routes.submit, {
            preserveScroll: true,
            onError: () => {
                setData((current) => ({ ...current, password: '', password_confirmation: '' }));
            },
        });
    };

    const update = (field, value) => {
        setData(field, value);
        clearErrors(field);
    };

    return (
        <AuthLayout
            title="Student Registration"
            routes={routes}
            formSide="left"
            formWidth="wide"
            accessLabel="Join the PGPC Library"
            headline="Start your"
            highlight="library journey."
            description="Create your student account to discover resources, reserve titles, and manage your library activity online."
            features={['Discover', 'Reserve', 'Learn']}
        >
            <div className="py-5 lg:py-6">
                <div className="mb-8">
                    <p className="mb-3 text-xs font-bold uppercase tracking-[0.2em] text-[#102b70]">Student registration</p>
                    <h2 className="text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">Create your account</h2>
                    <p className="mt-3 leading-7 text-slate-500">Use your current student information to join the PGPC Library.</p>
                </div>

                {Object.keys(errors).length > 0 && (
                    <div role="alert" className="mb-6 rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                        <p className="font-bold">Please review your information.</p>
                        <p className="mt-0.5">{Object.values(errors)[0]}</p>
                    </div>
                )}

                <form onSubmit={submit} className="space-y-6" noValidate>
                    <FormSection number="1" title="Student information">
                        <Field label="Student ID number" field="student_id_number" value={data.student_id_number} error={errors.student_id_number} onChange={update} placeholder="e.g. 04-12345" required />
                        <div className="grid gap-5 sm:grid-cols-2">
                            <Field label="First name" field="first_name" value={data.first_name} error={errors.first_name} onChange={update} placeholder="Juan" autoComplete="given-name" required />
                            <Field label="Last name" field="last_name" value={data.last_name} error={errors.last_name} onChange={update} placeholder="Dela Cruz" autoComplete="family-name" required />
                        </div>
                        <Field label="Middle name" optional field="middle_name" value={data.middle_name} error={errors.middle_name} onChange={update} placeholder="Santos" autoComplete="additional-name" />
                        <div className="grid gap-5 sm:grid-cols-2">
                            <Field label="Program" field="program" value={data.program} error={errors.program} onChange={update} placeholder="e.g. BSIT" required />
                            <SelectField label="Year level" field="year_level" value={data.year_level} error={errors.year_level} onChange={update} options={['1st Year', '2nd Year', '3rd Year', '4th Year']} />
                        </div>
                    </FormSection>

                    <FormSection number="2" title="Contact details">
                        <div className="grid gap-5 sm:grid-cols-2">
                            <Field label="Email address" field="email" type="email" value={data.email} error={errors.email} onChange={update} placeholder="student@pgpc.edu.ph" autoComplete="email" required />
                            <Field label="Contact number" optional field="contact_num" type="tel" value={data.contact_num} error={errors.contact_num} onChange={update} placeholder="0912 345 6789" autoComplete="tel" />
                        </div>
                    </FormSection>

                    <FormSection number="3" title="Account security">
                        <Field label="Username" field="username" value={data.username} error={errors.username} onChange={update} placeholder="Choose a username" autoComplete="username" required />
                        <div className="grid gap-5 sm:grid-cols-2">
                            <PasswordField label="Password" field="password" value={data.password} error={errors.password} onChange={update} visible={visiblePasswords.password} onToggle={() => setVisiblePasswords((state) => ({ ...state, password: !state.password }))} placeholder="At least 8 characters" />
                            <PasswordField label="Confirm password" field="password_confirmation" value={data.password_confirmation} error={errors.password_confirmation} onChange={update} visible={visiblePasswords.password_confirmation} onToggle={() => setVisiblePasswords((state) => ({ ...state, password_confirmation: !state.password_confirmation }))} placeholder="Repeat your password" />
                        </div>
                    </FormSection>

                    <label className="flex cursor-pointer items-start gap-3 rounded-2xl border border-slate-200 bg-white p-4 text-sm leading-6 text-slate-600">
                        <input type="checkbox" checked={data.terms} onChange={(event) => update('terms', event.target.checked)} className="mt-1 h-4 w-4 shrink-0 rounded border-slate-300 text-[#102b70] focus:ring-[#102b70]" />
                        <span>I agree to the <button type="button" onClick={() => setLegalDocument('terms')} className="font-bold text-[#102b70] underline decoration-[#fcc719] decoration-2 underline-offset-4">Terms of Service</button> and <button type="button" onClick={() => setLegalDocument('privacy')} className="font-bold text-[#102b70] underline decoration-[#fcc719] decoration-2 underline-offset-4">Privacy Policy</button>.</span>
                    </label>
                    {errors.terms && <p className="-mt-4 text-xs font-medium text-red-600">{errors.terms}</p>}

                    <button type="submit" disabled={processing} className="flex h-12 w-full items-center justify-center rounded-2xl bg-[#102b70] px-5 font-bold text-white shadow-lg transition hover:bg-[#0b225e] focus:ring-4 focus:ring-blue-200 disabled:cursor-not-allowed disabled:opacity-70">
                        {processing ? 'Creating account...' : 'Create student account'}
                    </button>
                </form>

                <div className="mt-8 border-t border-slate-200 pt-6 text-center text-sm text-slate-500">Already have an account? <a href={routes.login} className="ml-1 font-bold text-[#102b70] underline decoration-[#fcc719] decoration-2 underline-offset-4">Sign in</a></div>
            </div>

            {legalDocument && <LegalModal type={legalDocument} onClose={() => setLegalDocument(null)} />}
        </AuthLayout>
    );
}

function FormSection({ number, title, children }) {
    return <fieldset className="space-y-4"><legend className="mb-4 flex w-full items-center gap-3 text-sm font-bold text-slate-900"><span className="grid h-7 w-7 place-items-center rounded-full bg-blue-100 text-xs text-[#102b70]">{number}</span>{title}<span className="h-px flex-1 bg-slate-200" /></legend>{children}</fieldset>;
}

const inputClass = 'h-12 w-full rounded-2xl border border-slate-200 bg-white px-4 text-base text-slate-900 outline-none transition placeholder:text-slate-400 hover:border-slate-300 focus:border-[#102b70] focus:ring-4 focus:ring-blue-100 sm:text-sm';

function Field({ label, optional, field, type = 'text', value, error, onChange, ...props }) {
    return <div><label htmlFor={field} className="mb-2 block text-sm font-bold text-slate-700">{label} {optional && <span className="font-normal text-slate-400">(optional)</span>}</label><input id={field} name={field} type={type} value={value} onChange={(event) => onChange(field, event.target.value)} aria-invalid={Boolean(error)} className={inputClass} {...props} />{error && <p className="mt-1.5 text-xs font-medium text-red-600">{error}</p>}</div>;
}

function SelectField({ label, field, value, error, onChange, options }) {
    return <div><label htmlFor={field} className="mb-2 block text-sm font-bold text-slate-700">{label}</label><select id={field} name={field} value={value} onChange={(event) => onChange(field, event.target.value)} className={inputClass} required><option value="" disabled>Select year level</option>{options.map((option) => <option key={option} value={option}>{option}</option>)}</select>{error && <p className="mt-1.5 text-xs font-medium text-red-600">{error}</p>}</div>;
}

function PasswordField({ label, field, value, error, onChange, visible, onToggle, placeholder }) {
    return <div><label htmlFor={field} className="mb-2 block text-sm font-bold text-slate-700">{label}</label><div className="relative"><input id={field} name={field} type={visible ? 'text' : 'password'} value={value} onChange={(event) => onChange(field, event.target.value)} autoComplete="new-password" placeholder={placeholder} className={`${inputClass} pr-16`} required /><button type="button" onClick={onToggle} className="absolute right-3 top-1/2 -translate-y-1/2 text-xs font-bold text-slate-500 hover:text-[#102b70]">{visible ? 'Hide' : 'Show'}</button></div>{error && <p className="mt-1.5 text-xs font-medium text-red-600">{error}</p>}</div>;
}

const legalSections = {
    terms: [
        { title: 'Acceptance of Terms', text: "By accessing and using the Padre Garcia Polytechnic College (PGPC) Library System, you accept and agree to be bound by the terms and provisions of this agreement. In addition, when using this system's particular services, you shall be subject to any posted guidelines or rules applicable to such services." },
        { title: 'Provision of Services', text: 'PGPC Library reserves the right to modify, suspend, or discontinue the system with or without notice at any time and without any liability to you. The system is provided on an "as is" and "as available" basis.' },
        { title: 'User Conduct', text: 'As a user of the library system, you agree to the following:', bullets: ['You will not use the system for any illegal purposes.', 'You will not use the system to distribute malicious software or spam.', 'You are responsible for maintaining the confidentiality of your account credentials.', 'You will report any unauthorized use of your account immediately to the library administration.'] },
        { title: 'Borrowing and Returns', text: 'Physical books reserved through the system must be picked up within 48 hours. Users are responsible for the physical condition of borrowed materials and will be subject to fines for late returns, damages, or lost items in accordance with the official PGPC Library Handbook.' },
        { title: 'Termination', text: 'PGPC Library reserves the right to terminate your access to the system for violations of any of the terms outlined in this agreement, or for any conduct that the administration believes is harmful to other users, to the library, or to the college.' },
    ],
    privacy: [
        { title: 'Information Collection', text: 'When you use the PGPC Library System, we collect information you provide directly to us, such as when you create an account, update your profile, or communicate with us. This may include your name, student/faculty ID, email address, and borrowing history.' },
        { title: 'Use of Information', text: 'We use the information we collect to:', bullets: ['Provide, maintain, and improve the library services.', 'Process and track book reservations and borrowing.', 'Send you technical notices, updates, and security alerts.', 'Respond to your comments, questions, and customer service requests.'] },
        { title: 'Information Sharing', text: 'We do not share your personal information with outside parties except to the extent necessary to operate the system (e.g., cloud hosting providers) or when required by law or by the academic administration of Padre Garcia Polytechnic College.' },
        { title: 'Data Security', text: 'We implement reasonable security measures to protect your personal information against unauthorized access, alteration, disclosure, or destruction. However, no internet transmission is completely secure, and we cannot guarantee absolute security.' },
        { title: 'Contact Us', text: 'If you have any questions or concerns about this Privacy Policy or how your data is handled, please contact the PGPC Library Administration office or the IT Support Desk.' },
    ],
};

function LegalModal({ type, onClose }) {
    const title = type === 'terms' ? 'Terms of Service' : 'Privacy Policy';
    return <div role="dialog" aria-modal="true" aria-labelledby="legal-title" className="fixed inset-0 z-[100] grid place-items-center bg-slate-950/60 p-4"><div className="max-h-[85dvh] w-full max-w-4xl overflow-y-auto rounded-3xl bg-slate-50 shadow-2xl"><div className="sticky top-0 flex items-center justify-between bg-[#102b70] px-6 py-5 text-white"><div><h2 id="legal-title" className="text-2xl font-bold">{title}</h2><p className="text-sm text-blue-100">Last updated: June 2026</p></div><button type="button" onClick={onClose} className="grid h-10 w-10 place-items-center rounded-full bg-white/10 text-xl" aria-label={`Close ${title}`}>×</button></div><div className="space-y-7 p-6 sm:p-10">{legalSections[type].map((section, index) => <section key={section.title}><h3 className="mb-3 border-b border-slate-200 pb-2 text-xl font-bold text-slate-900">{index + 1}. {section.title}</h3><p className="leading-7 text-slate-700">{section.text}</p>{section.bullets && <ul className="mt-3 list-disc space-y-2 pl-6 text-slate-700">{section.bullets.map((item) => <li key={item}>{item}</li>)}</ul>}</section>)}</div></div></div>;
}
