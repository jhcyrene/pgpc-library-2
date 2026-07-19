import { useForm } from '@inertiajs/react';
import { useRef } from 'react';

import RecoveryCard from '../../components/Auth/RecoveryCard';
import AuthLayout from '../../Layouts/AuthLayout';

export default function VerifyCode({ email, routes }) {
    const inputs = useRef([]);
    const verification = useForm({ digits: ['', '', '', '', '', ''] });
    const resend = useForm({ email });

    const updateDigit = (index, value) => {
        const digit = value.replace(/\D/g, '').slice(-1);
        const digits = [...verification.data.digits];
        digits[index] = digit;
        verification.setData('digits', digits);
        verification.clearErrors('digits');
        if (digit && index < 5) inputs.current[index + 1]?.focus();
    };

    return (
        <AuthLayout title="Verify Code" routes={routes} accessLabel="Secure verification" headline="Check your email." highlight="Confirm your identity." description="Enter the one-time code sent to your student email address." features={['Email', 'Code', 'Secure']}>
            <RecoveryCard title="Check your email" description={<>We've sent a 6-digit verification code to <strong className="text-slate-700">{email}</strong>.</>} backUrl={routes.back}>
                <form onSubmit={(event) => { event.preventDefault(); verification.post(routes.verify, { preserveScroll: true }); }} className="space-y-6">
                    <div className="flex justify-between gap-2 sm:gap-3">{verification.data.digits.map((digit, index) => <input key={index} ref={(node) => { inputs.current[index] = node; }} type="text" inputMode="numeric" maxLength="1" value={digit} onChange={(event) => updateDigit(index, event.target.value)} onKeyDown={(event) => { if (event.key === 'Backspace' && !digit && index > 0) inputs.current[index - 1]?.focus(); }} autoFocus={index === 0} aria-label={`Verification digit ${index + 1}`} className="h-12 w-10 rounded-xl border border-slate-200 bg-slate-50 text-center text-xl font-bold text-slate-800 outline-none focus:border-[#102b70] focus:ring-2 focus:ring-blue-100 sm:h-14 sm:w-12" />)}</div>
                    {(verification.errors.digits || verification.errors['digits.0']) && <p className="text-center text-sm text-red-600">{verification.errors.digits || verification.errors['digits.0']}</p>}
                    <button type="submit" disabled={verification.processing} className="w-full rounded-full bg-[#102b70] py-3.5 font-bold text-white disabled:opacity-70">{verification.processing ? 'Verifying...' : 'Verify Code'}</button>
                </form>
                <form onSubmit={(event) => { event.preventDefault(); resend.post(routes.resend, { preserveScroll: true }); }} className="mt-8 text-center text-sm"><span className="text-slate-500">Didn't receive the code?</span><button type="submit" disabled={resend.processing} className="ml-1 font-bold text-[#102b70] disabled:opacity-70">{resend.processing ? 'Sending...' : 'Send another'}</button></form>
            </RecoveryCard>
        </AuthLayout>
    );
}
