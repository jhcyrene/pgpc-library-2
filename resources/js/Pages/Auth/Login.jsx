import LoginForm from '../../components/Auth/LoginForm';
import AuthLayout from '../../Layouts/AuthLayout';

export default function Login({ routes }) {
    return (
        <AuthLayout
            title="Student Login"
            routes={routes}
            formSide="left"
            accessLabel="Student library access"
            headline="Your library,"
            highlight="always within reach."
            description="Search the collection, review borrowed books, manage reservations, and stay on top of due dates."
            features={['Discover', 'Reserve', 'Track']}
        >
            <LoginForm
                action={routes.submit}
                portal="Student"
                description="Sign in to access your personal library account."
                loginLabel="Username or Student ID"
                loginPlaceholder="Enter username or student ID"
                buttonLabel="Sign in to your account"
                passwordAside={<a href={routes.forgotPassword} className="text-sm font-bold text-[#102b70] hover:text-blue-800">Forgot password?</a>}
                footer={<>
                    <p className="text-sm text-slate-500">New to the PGPC Library? <a href={routes.register} className="ml-1 font-bold text-[#102b70] underline decoration-[#fcc719] decoration-2 underline-offset-4">Create an account</a></p>
                    <p className="mt-5 text-xs text-slate-400">Library employee? <a href={routes.staffLogin} className="ml-1 font-semibold text-slate-500 hover:text-[#102b70]">Staff login</a></p>
                </>}
            />
        </AuthLayout>
    );
}
