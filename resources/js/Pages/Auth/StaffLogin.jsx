import LoginForm from '../../components/Auth/LoginForm';
import AuthLayout from '../../Layouts/AuthLayout';

export default function StaffLogin({ routes }) {
    return (
        <AuthLayout title="Staff Login" routes={routes}>
            <LoginForm
                action={routes.submit}
                portal="Staff"
                description="Administrators and librarians can sign in here to access their assigned workspace."
                loginLabel="Username"
                loginPlaceholder="Enter your staff username"
                buttonLabel="Enter staff portal"
                passwordAside={<span className="text-xs font-medium text-slate-400">Case-sensitive</span>}
                footer={<>
                    <p className="text-sm text-slate-500">Student or library member? <a href={routes.studentLogin} className="ml-1 font-bold text-[#102b70] underline decoration-[#fcc719] decoration-2 underline-offset-4">Go to student login</a></p>
                    <p className="mt-5 text-xs leading-5 text-slate-400">Having trouble signing in? Contact the system administrator.</p>
                </>}
            />
        </AuthLayout>
    );
}
