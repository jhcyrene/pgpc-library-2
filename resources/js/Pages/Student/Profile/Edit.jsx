import { useForm } from '@inertiajs/react';
import { useEffect, useState } from 'react';

import StudentLayout from '../../../Layouts/StudentLayout';
import ProfileAvatar from '../../../components/student/ProfileAvatar';

export default function Edit({ profile }) {
    const form = useForm({
        _method: 'put',
        first_name: profile.firstName || '',
        last_name: profile.lastName || '',
        email: profile.email || '',
        contact_num: profile.contactNumber || '',
        profile_image: null,
    });
    const [preview, setPreview] = useState(null);

    useEffect(() => () => { if (preview) URL.revokeObjectURL(preview); }, [preview]);

    const selectImage = (event) => {
        const file = event.target.files?.[0] || null;
        if (preview) URL.revokeObjectURL(preview);
        setPreview(file ? URL.createObjectURL(file) : null);
        form.setData('profile_image', file);
    };
    const submit = (event) => {
        event.preventDefault();
        form.post(profile.actions.update, { forceFormData: true });
    };

    return <StudentLayout title="Edit Profile" active="profile"><div className="mx-auto max-w-2xl space-y-5"><a href={profile.actions.show} className="inline-flex text-sm font-bold text-slate-500 hover:text-[#102b70]">← Back to profile</a><section className="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm"><div className="border-b border-slate-100 bg-[#102b70] p-6 text-white"><p className="text-xs font-bold uppercase tracking-wider text-blue-200">Student account</p><h1 className="mt-2 text-2xl font-black">Edit profile</h1></div><form onSubmit={submit} className="space-y-6 p-6 md:p-8"><div className="flex flex-col items-center gap-5 rounded-xl border border-slate-200 bg-slate-50 p-5 sm:flex-row"><ProfileAvatar profile={profile} preview={preview} /><div className="w-full"><label htmlFor="profile_image" className="mb-1.5 block text-sm font-bold text-slate-700">Profile picture</label><input id="profile_image" type="file" accept="image/jpeg,image/png,image/jpg" onChange={selectImage} className="block w-full text-sm text-slate-600 file:mr-3 file:rounded-lg file:border-0 file:bg-[#102b70] file:px-4 file:py-2.5 file:text-xs file:font-bold file:text-white" />{form.errors.profile_image && <Error message={form.errors.profile_image} />}<p className="mt-2 text-xs text-slate-500">JPG or PNG, maximum 2 MB.</p></div></div><div className="grid gap-5 sm:grid-cols-2"><Field label="First name" name="first_name" value={form.data.first_name} error={form.errors.first_name} onChange={(value) => form.setData('first_name', value)} /><Field label="Last name" name="last_name" value={form.data.last_name} error={form.errors.last_name} onChange={(value) => form.setData('last_name', value)} /></div><Field label="Email address" name="email" type="email" value={form.data.email} error={form.errors.email} onChange={(value) => form.setData('email', value)} /><Field label="Phone number" name="contact_num" value={form.data.contact_num} error={form.errors.contact_num} onChange={(value) => form.setData('contact_num', value)} required={false} /><div className="flex flex-col-reverse gap-3 border-t border-slate-100 pt-6 sm:flex-row sm:justify-end"><a href={profile.actions.show} className="rounded-xl px-5 py-3 text-center text-sm font-bold text-slate-600 hover:bg-slate-100">Cancel</a><button type="submit" disabled={form.processing} className="rounded-xl bg-[#102b70] px-6 py-3 text-sm font-bold text-white disabled:opacity-60">{form.processing ? 'Saving…' : 'Save changes'}</button></div></form></section></div></StudentLayout>;
}

function Field({ label, name, type = 'text', value, error, onChange, required = true }) { return <div><label htmlFor={name} className="mb-1.5 block text-sm font-bold text-slate-700">{label}</label><input id={name} type={type} value={value} onChange={(event) => onChange(event.target.value)} required={required} className="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-3 text-sm outline-none focus:border-[#102b70]" />{error && <Error message={error} />}</div>; }
function Error({ message }) { return <p className="mt-1 text-xs font-semibold text-red-600">{message}</p>; }
