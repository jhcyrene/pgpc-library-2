<x-layout.adminLogin
    title="Student Registration"
    portal="Student Portal"
    form-side="left"
    form-width="wide"
    access-label="Join the PGPC Library"
    headline="Start your"
    highlight="library journey."
    description="Create your student account to discover resources, reserve titles, and manage your library activity online."
    :features="['Discover', 'Reserve', 'Learn']"
>
    <x-auth.student.register-card />
</x-layout.adminLogin>
