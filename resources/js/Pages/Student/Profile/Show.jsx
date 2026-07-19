import { usePage } from '@inertiajs/react';

import StudentLayout from '../../../Layouts/StudentLayout';
import ProfileAvatar from '../../../components/student/ProfileAvatar';

export default function Show({ profile }) {
    const { flash } = usePage().props;
    const details = [
        ['First name', profile.firstName],
        ['Last name', profile.lastName],
        ['Email address', profile.email],
        ['Phone number', profile.contactNumber || 'Not provided'],
        ['Student ID', profile.studentId || 'Not provided'],
        ['Program', profile.program || 'Not provided'],
        ['Year level', profile.yearLevel || 'Not provided'],
    ];

    return <StudentLayout title="My Profile" active="profile"><div className="mx-auto max-w-4xl space-y-5"><section className="rounded-2xl bg-[#102b70] p-6 text-white shadow-md"><p className="text-xs font-bold uppercase tracking-[0.16em] text-blue-200">Student account</p><h1 className="mt-2 text-3xl font-black">My profile</h1><p className="mt-2 text-sm text-slate-300">Review and manage your personal information.</p></section>{flash?.success && <div role="status" className="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-bold text-emerald-700">{flash.success}</div>}<section className="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm"><div className="flex flex-col items-center gap-5 border-b border-slate-100 bg-slate-50/60 p-6 sm:flex-row sm:p-8"><ProfileAvatar profile={profile} /><div className="text-center sm:text-left"><h2 className="text-2xl font-black text-slate-900">{profile.firstName} {profile.lastName}</h2><p className="mt-1 font-semibold text-[#102b70]">Student</p><p className="mt-1 text-xs text-slate-400">Member since {profile.memberSince || '—'}</p></div><a href={profile.actions.edit} className="rounded-xl bg-[#102b70] px-5 py-3 text-sm font-bold text-white sm:ml-auto">Edit profile</a></div><dl className="grid gap-x-8 gap-y-6 p-6 sm:grid-cols-2 sm:p-8">{details.map(([label, value]) => <div key={label}><dt className="text-[10px] font-bold uppercase tracking-wider text-slate-400">{label}</dt><dd className="mt-1 text-sm font-bold text-slate-800">{value}</dd></div>)}</dl></section></div></StudentLayout>;
}
