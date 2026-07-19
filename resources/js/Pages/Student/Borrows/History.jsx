import StudentLayout from '../../../Layouts/StudentLayout';
import BorrowPage from '../../../components/student/BorrowPage';

export default function History({ borrows, filters }) {
    return <StudentLayout title="Borrow History" active="history"><BorrowPage title="Borrow history" description="Review books you previously borrowed and returned." borrows={borrows} mode="history" sort={filters.sort} sortOptions={[["return_date_desc", "Recently returned"], ["return_date_asc", "Oldest returned"]]} /></StudentLayout>;
}
