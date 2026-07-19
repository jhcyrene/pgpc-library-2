import { useForm } from '@inertiajs/react';

import RecoveryCard from '../../components/Auth/RecoveryCard';
import AuthLayout from '../../Layouts/AuthLayout';

export default function ForgotPassword({ routes }) {
    const { data, setData, post, processing, errors, clearErrors } = useForm({ email: '' });
    const submit = (event) => { event.preventDefault(); post(routes.submit, { preserveScroll: true }); };

    return (
        <AuthLayout title="Forgot Password" routes={routes} accessLabel="Student account recovery" headline="Recover access." highlight="Return to learning." description="Verify your student email to securely reset your library password." features={['Verify', 'Reset', 'Return']}>
            <RecoveryCard title="Reset Password" description="Enter your student email and we'll send a six-digit verification code." backUrl={routes.login} backLabel="Back to login">
                <form onSubmit={submit} className="space-y-6" noValidate>
                    <div><label htmlFor="email" className="mb-2 block text-sm font-semibold text-slate-700">Email Address</label><input id="email" type="email" value={data.email} onChange={(event) => { setData('email', event.target.value); clearErrors('email'); }} required autoFocus autoComplete="email" placeholder="student@pgpc.edu.ph" className="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-slate-800 outline-none focus:border-[#102b70] focus:ring-2 focus:ring-blue-100" />{errors.email && <p className="mt-2 text-sm text-red-600">{errors.email}</p>}</div>
                    <button type="submit" disabled={processing} className="w-full rounded-full bg-[#102b70] py-3.5 font-bold text-white transition hover:bg-[#0b225e] disabled:opacity-70">{processing ? 'Sending code...' : 'Send Verification Code'}</button>
                </form>
            </RecoveryCard>
        </AuthLayout>
    );
}
