import { useForm } from '@inertiajs/react';

import RecoveryCard from '../../components/Auth/RecoveryCard';
import AuthLayout from '../../Layouts/AuthLayout';

export default function ResetPassword({ routes }) {
    const form = useForm({ password: '', password_confirmation: '' });
    const submit = (event) => { event.preventDefault(); form.post(routes.submit, { preserveScroll: true, onError: () => form.reset('password', 'password_confirmation') }); };

    return (
        <AuthLayout title="Create New Password" routes={routes} accessLabel="Secure password reset" headline="Create a new key." highlight="Protect your account." description="Choose a strong new password for your PGPC Library account." features={['Strong', 'Private', 'Secure']}>
            <RecoveryCard title="Create a new password" description="Use at least eight characters with both letters and numbers.">
                <form onSubmit={submit} className="space-y-5" noValidate>
                    <PasswordInput label="New Password" field="password" form={form} />
                    <PasswordInput label="Confirm New Password" field="password_confirmation" form={form} />
                    <button type="submit" disabled={form.processing} className="w-full rounded-full bg-[#102b70] py-3.5 font-bold text-white disabled:opacity-70">{form.processing ? 'Saving password...' : 'Save New Password'}</button>
                </form>
            </RecoveryCard>
        </AuthLayout>
    );
}

function PasswordInput({ label, field, form }) {
    return <div><label htmlFor={field} className="mb-2 block text-sm font-semibold text-slate-700">{label}</label><input id={field} type="password" value={form.data[field]} onChange={(event) => { form.setData(field, event.target.value); form.clearErrors(field); }} required autoComplete="new-password" className="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-slate-800 outline-none focus:border-[#102b70] focus:ring-2 focus:ring-blue-100" />{form.errors[field] && <p className="mt-2 text-sm text-red-600">{form.errors[field]}</p>}</div>;
}
