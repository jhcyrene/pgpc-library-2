import { usePage } from '@inertiajs/react';

import StudentLayout from '../../../Layouts/StudentLayout';
import BorrowPage from '../../../components/student/BorrowPage';

export default function Current({ borrows, filters }) {
    const { routes } = usePage().props.studentPortal;
    return <StudentLayout title="Current Borrows" active="current-borrows"><BorrowPage title="Current borrows" description="Track the books currently assigned to your account and their due dates." borrows={borrows} mode="current" sort={filters.sort} sortOptions={[["due_date_asc", "Due date: earliest"], ["due_date_desc", "Due date: latest"], ["issue_date_desc", "Recently borrowed"]]} actions={<a href={routes.overdue} className="rounded-xl bg-[#fcc719] px-5 py-3 text-center text-sm font-bold text-[#102b70]">View overdue items</a>} /></StudentLayout>;
}
