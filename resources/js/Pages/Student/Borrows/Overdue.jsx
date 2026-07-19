import { usePage } from '@inertiajs/react';

import StudentLayout from '../../../Layouts/StudentLayout';
import BorrowPage from '../../../components/student/BorrowPage';

export default function Overdue({ borrows }) {
    const { routes } = usePage().props.studentPortal;
    return <StudentLayout title="Overdue Items" active="overdue"><BorrowPage title="Overdue items" description="Please return these books as soon as possible. Fine amounts may update after library review." borrows={borrows} mode="overdue" actions={<a href={routes.fines} className="rounded-xl bg-[#fcc719] px-5 py-3 text-center text-sm font-bold text-[#102b70]">Review fines</a>} /></StudentLayout>;
}
