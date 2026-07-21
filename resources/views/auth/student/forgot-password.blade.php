<x-layout.adminLogin
    title="Forgot Password"
    portal="Student Portal"
    form-side="left"
    access-label="Student account recovery"
    headline="Recover your"
    highlight="account securely."
    description="We'll help you get back into your account safely and quickly."
    :features="['Email Verification', 'Secure Reset', 'Fast Access']"
>
    <x-auth.forgotPasswordCard />
</x-layout.adminLogin>
