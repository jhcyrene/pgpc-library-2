import { useForm, usePage } from '@inertiajs/react';
import { useState } from 'react';

export default function LoginForm({
    action,
    portal,
    description,
    loginLabel,
    loginPlaceholder,
    buttonLabel,
    passwordAside,
    footer,
}) {
    const [showPassword, setShowPassword] = useState(false);
    const { flash } = usePage().props;
    const { data, setData, post, processing, errors, clearErrors } = useForm({
        login: '',
        password: '',
        remember: false,
    });

    const submit = (event) => {
        event.preventDefault();
        post(action, {
            preserveScroll: true,
            onError: () => setData('password', ''),
        });
    };

    const firstError = errors.login || errors.password || flash?.error;

    return (
        <div>
            <div className="mb-8">
                <p className="mb-3 text-xs font-bold uppercase tracking-[0.2em] text-[#102b70]">{portal} access</p>
                <h2 className="text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">Welcome back</h2>
                <p className="mt-3 leading-7 text-slate-500">{description}</p>
            </div>

            {firstError && (
                <div role="alert" className="mb-6 flex gap-3 rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                    <span aria-hidden="true" className="font-bold">!</span>
                    <div><p className="font-bold">We couldn't sign you in.</p><p className="mt-0.5">{firstError}</p></div>
                </div>
            )}

            {(flash?.success || flash?.status) && (
                <div role="status" className="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-sm font-medium text-emerald-700">
                    {flash.success || flash.status}
                </div>
            )}

            <form onSubmit={submit} className="space-y-5" noValidate>
                <div>
                    <label htmlFor="login" className="mb-2 block text-sm font-bold text-slate-700">{loginLabel}</label>
                    <input
                        id="login"
                        name="login"
                        type="text"
                        value={data.login}
                        onChange={(event) => { setData('login', event.target.value); clearErrors('login'); }}
                        required
                        autoFocus
                        autoComplete="username"
                        placeholder={loginPlaceholder}
                        aria-invalid={Boolean(errors.login)}
                        aria-describedby={errors.login ? 'login-error' : undefined}
                        className="h-14 w-full rounded-2xl border border-slate-200 bg-white px-4 text-base text-slate-900 outline-none transition placeholder:text-slate-400 hover:border-slate-300 focus:border-[#102b70] focus:ring-4 focus:ring-blue-100 sm:text-sm"
                    />
                    {errors.login && <p id="login-error" className="mt-1.5 text-xs font-medium text-red-600">{errors.login}</p>}
                </div>

                <div>
                    <div className="mb-2 flex items-center justify-between">
                        <label htmlFor="password" className="block text-sm font-bold text-slate-700">Password</label>
                        {passwordAside}
                    </div>
                    <div className="relative">
                        <input
                            id="password"
                            name="password"
                            type={showPassword ? 'text' : 'password'}
                            value={data.password}
                            onChange={(event) => { setData('password', event.target.value); clearErrors('password'); }}
                            required
                            autoComplete="current-password"
                            placeholder="Enter your password"
                            aria-invalid={Boolean(errors.password)}
                            aria-describedby={errors.password ? 'password-error' : undefined}
                            className="h-14 w-full rounded-2xl border border-slate-200 bg-white px-4 pr-14 text-base text-slate-900 outline-none transition placeholder:text-slate-400 hover:border-slate-300 focus:border-[#102b70] focus:ring-4 focus:ring-blue-100 sm:text-sm"
                        />
                        <button type="button" onClick={() => setShowPassword((visible) => !visible)} aria-label={showPassword ? 'Hide password' : 'Show password'} className="absolute right-2 top-1/2 grid h-10 w-10 -translate-y-1/2 place-items-center rounded-xl text-slate-400 transition hover:bg-slate-100 hover:text-[#102b70] focus:outline-none focus:ring-2 focus:ring-blue-200">
                            {showPassword ? 'Hide' : 'Show'}
                        </button>
                    </div>
                    {errors.password && <p id="password-error" className="mt-1.5 text-xs font-medium text-red-600">{errors.password}</p>}
                </div>

                <label className="inline-flex cursor-pointer items-center gap-3 text-sm text-slate-600">
                    <input type="checkbox" name="remember" checked={data.remember} onChange={(event) => setData('remember', event.target.checked)} className="h-4 w-4 rounded border-slate-300 text-[#102b70] focus:ring-[#102b70]" />
                    Keep me signed in on this device
                </label>

                <button type="submit" disabled={processing} className="flex h-14 w-full items-center justify-center gap-2 rounded-2xl bg-[#102b70] px-5 font-bold text-white shadow-lg shadow-blue-900/15 transition hover:-translate-y-0.5 hover:bg-[#0b225e] hover:shadow-xl focus:outline-none focus:ring-4 focus:ring-blue-200 disabled:cursor-not-allowed disabled:opacity-70">
                    {processing ? 'Signing in...' : buttonLabel}
                </button>
            </form>

            <div className="mt-8 border-t border-slate-200 pt-6 text-center">{footer}</div>
        </div>
    );
}
