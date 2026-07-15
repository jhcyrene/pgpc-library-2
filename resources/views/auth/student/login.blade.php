<x-layout.adminLogin
    title="Student Login"
    portal="Student Portal"
    form-side="left"
    access-label="Student library access"
    headline="Your library,"
    highlight="always within reach."
    description="Search the collection, review borrowed books, manage reservations, and stay on top of due dates."
    :features="['Discover', 'Reserve', 'Track']"
>
    <x-auth.logincard />
</x-layout.adminLogin>
