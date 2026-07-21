<x-layout.adminLogin title="Staff Login" portal="Staff Portal">
    <x-auth.staff-login-card
        role="Staff"
        description="Administrators and librarians can sign in here to access their assigned workspace."
        :action="route('staff.login.store')"
        button-label="Enter staff portal"
    />
</x-layout.adminLogin>
