<div class="relative z-20 w-full max-w-md px-5 py-12 flex flex-col">
    <!-- Mobile Back to Home -->
    <a href="{{ route('home') }}" class="md:hidden flex items-center gap-2 text-white/90 hover:text-white transition-colors self-start mb-6 font-medium">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Back to Home
    </a>

    <div class="bg-white rounded-3xl shadow-elegant p-8 md:p-10 transform transition-all">
        <!-- Back to previous page -->
        <div class="border-gray-100 text-left pb-5">
            <a href="{{ route('forgot-password') }}" class="inline-flex items-center gap-2 text-sm font-bold text-gray-500 hover:text-primary transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back
            </a>
        </div>
        
        <!-- Icon -->
        <div class="flex justify-center mb-6">
            <div class="w-16 h-16 rounded-full bg-blue-50 flex items-center justify-center text-primary shadow-soft">
                <!-- Mail Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </div>
        </div>

        <!-- Header -->
        <div class="text-center mb-8">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2">Check your email</h2>
            <p class="text-gray-500 text-sm">We've sent a 6-digit verification code to <br><span class="font-bold text-gray-700">{{ session('password_reset_email') }}</span></p>
        </div>

        @if(session('status'))
            <x-alert type="success" message="{{ session('status') }}" class="mb-5" />
        @endif

        <!-- Form -->
        <form action="{{ route('forgot-password.verify') }}" method="POST" class="space-y-6">
            @csrf
            
            <!-- OTP Inputs -->
            <div class="flex justify-between gap-2 sm:gap-3" id="otp-container">
                @for ($i = 0; $i < 6; $i++)
                <input type="text" name="digits[]" inputmode="numeric" pattern="[0-9]" maxlength="1" required autocomplete="one-time-code"
                    class="otp-input w-10 h-12 sm:w-12 sm:h-14 text-center text-xl sm:text-2xl font-bold bg-gray-50 border border-gray-200 rounded-lg sm:rounded-xl text-gray-800 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all" />
                @endfor
            </div>
            @error('digits')<p class="text-sm text-red-600 text-center">{{ $message }}</p>@enderror
            @error('digits.*')<p class="text-sm text-red-600 text-center">{{ $message }}</p>@enderror

            <!-- Submit Button -->
            <div class="pt-2">
                <button type="submit" class="w-full bg-primary text-white hover:bg-primaryfade py-3.5 rounded-full font-bold shadow-soft hover:shadow-elegant transform transition-all hover:-translate-y-0.5">
                    Verify Code
                </button>
            </div>
        </form>

        <!-- Footer -->
        <form action="{{ route('forgot-password.send') }}" method="POST" class="mt-8 text-center">
            @csrf
            <input type="hidden" name="email" value="{{ session('password_reset_email') }}">
            <span class="text-sm text-gray-500">Didn't receive the code?</span>
            <button type="submit" class="font-bold text-primary hover:text-gold transition-colors ml-1 focus:outline-none">Send another</button>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const inputs = document.querySelectorAll('.otp-input');
        
        inputs.forEach((input, index) => {
            // Allow only numbers
            input.addEventListener('input', function(e) {
                this.value = this.value.replace(/[^0-9]/g, '');
                
                if (this.value !== '') {
                    // Move to next input
                    if (index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    }
                }
            });

            // Handle backspace
            input.addEventListener('keydown', function(e) {
                if (e.key === 'Backspace' && this.value === '') {
                    if (index > 0) {
                        inputs[index - 1].focus();
                    }
                }
            });
        });
    });
</script>
