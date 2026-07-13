# Student Reservation Flow

The reservation process is designed to be seamless, allowing students to browse the OPAC, request a book, and monitor its status.

## Step 1: Initiation
1. A student browses the public OPAC (Online Public Access Catalog).
2. They find a book they want and click "Reserve".
3. **If not logged in:** They are redirected to `/student/login` with an intended redirect URL stored in the session.
4. **If logged in (or after successful login):** They are directed to `/student/reservations/create/{bookData}`.

## Step 2: Eligibility Check
The `ReservationService` intercepts the request and verifies:
- Does the student have active, unpaid fines? (If yes, block)
- Does the student already have this specific book borrowed/reserved? (If yes, block)
- Are there available physical copies (`Book`) associated with this `BookData`? (If no, block)
- Is the student's account status 'active'? (If no, block)

## Step 3: Confirmation
1. The student is presented with the book details and a form to add optional remarks.
2. The student clicks "Confirm Reservation".
3. A `BookRequest` record is created, defaulting to the "Pending" status (usually ID 1).
4. The student is redirected to the Reservation Details page showing a timeline.

## Step 4: Processing (Librarian Side)
1. Librarians see the new "Pending" request on the admin dashboard.
2. A librarian locates the physical book on the shelf.
3. The librarian updates the status to "Ready for Pickup".
4. *(Future Enhancement)* An automated email is sent to the student.

## Step 5: Fulfillment
1. The student visits the physical library desk.
2. The librarian issues the book to the student, converting the `BookRequest` to a `BookBorrow` record.
3. The reservation status is updated to "Completed".
