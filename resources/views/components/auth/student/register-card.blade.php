<div class="py-5 lg:py-6">
    <div class="mb-8">
        <p class="mb-3 text-xs font-bold uppercase tracking-[0.2em] text-[#102b70]">Student registration</p>
        <h2 class="text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">Create your account</h2>
        <p class="mt-3 leading-7 text-slate-500">Use your current student information to join the PGPC Library.</p>
    </div>

    <div id="ajax-general-error" role="alert" class="mb-6 flex gap-3 rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-700 @if(!$errors->any()) hidden @endif">
        <svg class="mt-0.5 h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M5.07 19h13.86a2 2 0 001.74-3l-6.93-12a2 2 0 00-3.48 0L3.33 16a2 2 0 001.74 3z" />
        </svg>
        <div>
            <p class="font-bold">Please review your information.</p>
            <p class="mt-0.5" data-alert-message>{{ $errors->first() }}</p>
        </div>
    </div>

    @if (session('error'))
        <x-alert type="error" message="{{ session('error') }}" class="mb-4" />
    @endif

    @php
        $inputClass = 'h-12 w-full rounded-2xl border border-slate-200 bg-white px-4 text-base sm:text-sm text-slate-900 outline-none transition placeholder:text-slate-400 hover:border-slate-300 focus:border-[#102b70] focus:ring-4 focus:ring-blue-100';
        $labelClass = 'mb-2 block text-sm font-bold text-slate-700';
        $errorClass = 'mt-1.5 text-xs font-medium text-red-600';
    @endphp

    <form action="{{ route('register.store') }}" method="POST" class="space-y-6" data-ajax-form>
        @csrf

        <fieldset class="space-y-4">
            <legend class="mb-4 flex w-full items-center gap-3 text-sm font-bold text-slate-900">
                <span class="grid h-7 w-7 place-items-center rounded-full bg-blue-100 text-xs text-[#102b70]">1</span>
                Student information
                <span class="h-px flex-1 bg-slate-200"></span>
            </legend>

            <div>
                <label for="student_id_number" class="{{ $labelClass }}">Student ID number <span class="text-red-500">*</span></label>
                <input id="student_id_number" name="student_id_number" type="text" required value="{{ old('student_id_number') }}" placeholder="e.g. 04-12345" class="{{ $inputClass }}">
                <p data-error-for="student_id_number" class="{{ $errorClass }} @if(!$errors->has('student_id_number')) hidden @endif">{{ $errors->first('student_id_number') }}</p>
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="first_name" class="{{ $labelClass }}">First name <span class="text-red-500">*</span></label>
                    <input id="first_name" name="first_name" type="text" required autocomplete="given-name" value="{{ old('first_name') }}" placeholder="Juan" class="{{ $inputClass }}">
                    <p data-error-for="first_name" class="{{ $errorClass }} @if(!$errors->has('first_name')) hidden @endif">{{ $errors->first('first_name') }}</p>
                </div>
                <div>
                    <label for="last_name" class="{{ $labelClass }}">Last name <span class="text-red-500">*</span></label>
                    <input id="last_name" name="last_name" type="text" required autocomplete="family-name" value="{{ old('last_name') }}" placeholder="Dela Cruz" class="{{ $inputClass }}">
                    <p data-error-for="last_name" class="{{ $errorClass }} @if(!$errors->has('last_name')) hidden @endif">{{ $errors->first('last_name') }}</p>
                </div>
            </div>

            <div>
                <label for="middle_name" class="{{ $labelClass }}">Middle name <span class="font-normal text-slate-400">(optional)</span></label>
                <input id="middle_name" name="middle_name" type="text" autocomplete="additional-name" value="{{ old('middle_name') }}" placeholder="Santos" class="{{ $inputClass }}">
                <p data-error-for="middle_name" class="{{ $errorClass }} @if(!$errors->has('middle_name')) hidden @endif">{{ $errors->first('middle_name') }}</p>
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="program" class="{{ $labelClass }}">Program <span class="text-red-500">*</span></label>
                    <input id="program" name="program" type="text" required value="{{ old('program') }}" placeholder="e.g. BSIT" class="{{ $inputClass }}">
                    <p data-error-for="program" class="{{ $errorClass }} @if(!$errors->has('program')) hidden @endif">{{ $errors->first('program') }}</p>
                </div>
                <div>
                    <label for="year_level" class="{{ $labelClass }}">Year level <span class="text-red-500">*</span></label>
                    <select id="year_level" name="year_level" required class="{{ $inputClass }}">
                        <option value="" disabled @selected(!old('year_level'))>Select year level</option>
                        @foreach (['1st Year', '2nd Year', '3rd Year', '4th Year'] as $year)
                            <option value="{{ $year }}" @selected(old('year_level') === $year)>{{ $year }}</option>
                        @endforeach
                    </select>
                    <p data-error-for="year_level" class="{{ $errorClass }} @if(!$errors->has('year_level')) hidden @endif">{{ $errors->first('year_level') }}</p>
                </div>
            </div>
        </fieldset>

        <fieldset class="space-y-4">
            <legend class="mb-4 flex w-full items-center gap-3 text-sm font-bold text-slate-900">
                <span class="grid h-7 w-7 place-items-center rounded-full bg-blue-100 text-xs text-[#102b70]">2</span>
                Contact details
                <span class="h-px flex-1 bg-slate-200"></span>
            </legend>

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="email" class="{{ $labelClass }}">Email address <span class="text-red-500">*</span></label>
                    <input id="email" name="email" type="email" required autocomplete="email" value="{{ old('email') }}" placeholder="student@pgpc.edu.ph" class="{{ $inputClass }}">
                    <p data-error-for="email" class="{{ $errorClass }} @if(!$errors->has('email')) hidden @endif">{{ $errors->first('email') }}</p>
                </div>
                <div>
                    <label for="contact_num" class="{{ $labelClass }}">Contact number <span class="font-normal text-slate-400">(optional)</span></label>
                    <input id="contact_num" name="contact_num" type="tel" autocomplete="tel" value="{{ old('contact_num') }}" placeholder="0912 345 6789" class="{{ $inputClass }}">
                    <p data-error-for="contact_num" class="{{ $errorClass }} @if(!$errors->has('contact_num')) hidden @endif">{{ $errors->first('contact_num') }}</p>
                </div>
            </div>
        </fieldset>

        <fieldset class="space-y-4">
            <legend class="mb-4 flex w-full items-center gap-3 text-sm font-bold text-slate-900">
                <span class="grid h-7 w-7 place-items-center rounded-full bg-blue-100 text-xs text-[#102b70]">3</span>
                Account security
                <span class="h-px flex-1 bg-slate-200"></span>
            </legend>

            <div>
                <label for="username" class="{{ $labelClass }}">Username <span class="text-red-500">*</span></label>
                <input id="username" name="username" type="text" required autocomplete="username" value="{{ old('username') }}" placeholder="Choose a username" class="{{ $inputClass }}">
                <p data-error-for="username" class="{{ $errorClass }} @if(!$errors->has('username')) hidden @endif">{{ $errors->first('username') }}</p>
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="password" class="{{ $labelClass }}">Password <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <input id="password" name="password" type="password" required autocomplete="new-password" placeholder="At least 8 characters" class="{{ $inputClass }} pr-12" data-register-password>
                        <button type="button" data-register-password-toggle="password" aria-label="Show password" class="absolute right-2 top-1/2 grid h-9 w-9 -translate-y-1/2 place-items-center rounded-xl text-slate-400 hover:bg-slate-100 hover:text-[#102b70]">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.46 12C3.73 7.94 7.52 5 12 5c4.48 0 8.27 2.94 9.54 7-1.27 4.06-5.06 7-9.54 7-4.48 0-8.27-2.94-9.54-7z"/></svg>
                        </button>
                    </div>
                    <p data-error-for="password" class="{{ $errorClass }} @if(!$errors->has('password')) hidden @endif">{{ $errors->first('password') }}</p>
                </div>
                <div>
                    <label for="password_confirmation" class="{{ $labelClass }}">Confirm password <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password" placeholder="Repeat your password" class="{{ $inputClass }} pr-12" data-register-password>
                        <button type="button" data-register-password-toggle="password_confirmation" aria-label="Show password confirmation" class="absolute right-2 top-1/2 grid h-9 w-9 -translate-y-1/2 place-items-center rounded-xl text-slate-400 hover:bg-slate-100 hover:text-[#102b70]">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.46 12C3.73 7.94 7.52 5 12 5c4.48 0 8.27 2.94 9.54 7-1.27 4.06-5.06 7-9.54 7-4.48 0-8.27-2.94-9.54-7z"/></svg>
                        </button>
                    </div>
                </div>
            </div>
        </fieldset>

        <label class="flex cursor-pointer items-start gap-3 rounded-2xl border border-slate-200 bg-white p-4 text-sm leading-6 text-slate-600">
            <input type="checkbox" name="terms" value="1" required @checked(old('terms')) class="mt-1 h-4 w-4 shrink-0 rounded border-slate-300 text-[#102b70] focus:ring-[#102b70]">
            <span>
                I agree to the
                <button type="button" onclick="terms_modal.showModal()" class="font-bold text-[#102b70] underline decoration-[#fcc719] decoration-2 underline-offset-4">Terms of Service</button>
                and
                <button type="button" onclick="privacy_modal.showModal()" class="font-bold text-[#102b70] underline decoration-[#fcc719] decoration-2 underline-offset-4">Privacy Policy</button>.
            </span>
        </label>

        <button type="submit" class="group flex h-12 w-full items-center justify-center gap-2 rounded-2xl bg-[#102b70] px-5 font-bold text-white shadow-lg shadow-blue-900/15 transition hover:-translate-y-0.5 hover:bg-[#0b225e] hover:shadow-xl focus:outline-none focus:ring-4 focus:ring-blue-200 active:translate-y-0">
            Create student account
            <svg class="h-5 w-5 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
        </button>
    </form>

    <!-- Social Sign In Divider -->
    <div class="relative my-6">
        <div class="absolute inset-0 flex items-center" aria-hidden="true">
            <div class="w-full border-t border-slate-200"></div>
        </div>
        <div class="relative flex justify-center text-xs uppercase font-extrabold tracking-wide">
            <span class="bg-white px-4 text-slate-400">Or sign up with</span>
        </div>
    </div>

    <!-- Google SignUp Button -->
    <div class="mb-2">
        <a href="{{ route('auth.google') }}" class="w-full flex items-center justify-center gap-2.5 py-3 border border-slate-200 hover:bg-slate-50 transition-colors rounded-2xl text-sm font-bold text-slate-700 bg-white shadow-xs">
            <svg class="h-5 w-5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z" fill="#FBBC05"/>
                <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z" fill="#EA4335"/>
            </svg>
            Sign up with Google
        </a>
    </div>

    <div class="mt-8 border-t border-slate-200 pt-6 text-center">
        <p class="text-sm text-slate-500">
            Already have an account?
            <a href="{{ route('login') }}" class="ml-1 font-bold text-[#102b70] underline decoration-[#fcc719] decoration-2 underline-offset-4">Sign in</a>
        </p>
    </div>
</div>

<dialog id="terms_modal" class="modal modal-bottom sm:modal-middle">
    <div class="modal-box h-[85dvh] w-full max-w-5xl overflow-y-auto bg-slate-50 p-0">
        <form method="dialog" class="sticky top-4 z-20 ml-auto mr-4 w-fit"><button class="btn btn-circle btn-sm bg-slate-900/70 text-white">✕</button></form>
        <x-auth.termsCard />
    </div>
    <form method="dialog" class="modal-backdrop"><button>Close</button></form>
</dialog>

<dialog id="privacy_modal" class="modal modal-bottom sm:modal-middle">
    <div class="modal-box h-[85dvh] w-full max-w-5xl overflow-y-auto bg-slate-50 p-0">
        <form method="dialog" class="sticky top-4 z-20 ml-auto mr-4 w-fit"><button class="btn btn-circle btn-sm bg-slate-900/70 text-white">✕</button></form>
        <x-auth.privacypolicyCard />
    </div>
    <form method="dialog" class="modal-backdrop"><button>Close</button></form>
</dialog>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('[data-register-password-toggle]').forEach((button) => {
            button.addEventListener('click', () => {
                const input = document.getElementById(button.dataset.registerPasswordToggle);
                const willShow = input.type === 'password';
                input.type = willShow ? 'text' : 'password';
                button.setAttribute('aria-label', willShow ? 'Hide password' : 'Show password');
            });
        });
    });
</script>


