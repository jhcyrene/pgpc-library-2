<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property string $first_name
 * @property string|null $middle_name
 * @property string $last_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Book> $books
 * @property-read int|null $books_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Author newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Author newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Author query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Author whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Author whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Author whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Author whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Author whereMiddleName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Author whereUpdatedAt($value)
 */
	class Author extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $book_data_id
 * @property string $accession_number
 * @property string $status
 * @property string|null $last_modified
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Author> $authors
 * @property-read int|null $authors_count
 * @property-read \App\Models\BookData $bookData
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\BookBorrow> $borrows
 * @property-read int|null $borrows_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\BookRequest> $requests
 * @property-read int|null $requests_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Book newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Book newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Book query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Book whereAccessionNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Book whereBookDataId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Book whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Book whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Book whereLastModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Book whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Book whereUpdatedAt($value)
 */
	class Book extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $book_id
 * @property int $member_id
 * @property int $librarian_id
 * @property string $borrow_date
 * @property string $due_date
 * @property string|null $return_date
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookBorrow newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookBorrow newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookBorrow query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookBorrow whereBookId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookBorrow whereBorrowDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookBorrow whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookBorrow whereDueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookBorrow whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookBorrow whereLibrarianId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookBorrow whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookBorrow whereReturnDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookBorrow whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookBorrow whereUpdatedAt($value)
 */
	class BookBorrow extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $call_number
 * @property string $isbn
 * @property string $book_title
 * @property string $author
 * @property string $classification_letter
 * @property int $category_id
 * @property int $publisher_id
 * @property int|null $publication_year
 * @property string|null $edition
 * @property string|null $description
 * @property int $copies_total
 * @property int $copies_available
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Book> $books
 * @property-read int|null $books_count
 * @property-read \App\Models\Category $category
 * @property-read \App\Models\Classification|null $classification
 * @property-read \App\Models\Publisher $publisher
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookData newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookData newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookData query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookData whereAuthor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookData whereBookTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookData whereCallNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookData whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookData whereClassificationLetter($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookData whereCopiesAvailable($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookData whereCopiesTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookData whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookData whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookData whereEdition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookData whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookData whereIsbn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookData wherePublicationYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookData wherePublisherId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookData whereUpdatedAt($value)
 */
	class BookData extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $book_id
 * @property int $member_id
 * @property int $book_request_status_id
 * @property string $request_date
 * @property string|null $needed_until
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookRequest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookRequest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookRequest query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookRequest whereBookId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookRequest whereBookRequestStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookRequest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookRequest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookRequest whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookRequest whereNeededUntil($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookRequest whereRequestDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookRequest whereUpdatedAt($value)
 */
	class BookRequest extends \Eloquent {}
}

namespace App\Models{
/**
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\BookRequest> $requests
 * @property-read int|null $requests_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookRequest_Status newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookRequest_Status newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookRequest_Status query()
 */
	class BookRequest_Status extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $category_name
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\BookData> $bookData
 * @property-read int|null $book_data_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereCategoryName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereUpdatedAt($value)
 */
	class Category extends \Eloquent {}
}

namespace App\Models{
/**
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Classification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Classification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Classification query()
 */
	class Classification extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $employee_number
 * @property string $first_name
 * @property string|null $middle_name
 * @property string $last_name
 * @property string $email
 * @property string|null $contact_number
 * @property string $username
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Librarian newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Librarian newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Librarian query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Librarian whereContactNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Librarian whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Librarian whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Librarian whereEmployeeNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Librarian whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Librarian whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Librarian whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Librarian whereMiddleName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Librarian wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Librarian whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Librarian whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Librarian whereUsername($value)
 */
	class Librarian extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $student_number
 * @property string $first_name
 * @property string|null $middle_name
 * @property string $last_name
 * @property string $email
 * @property string|null $contact_number
 * @property string $program
 * @property string $year_level
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\MemberAuth|null $auth
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\BookBorrow> $borrows
 * @property-read int|null $borrows_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\BookRequest> $requests
 * @property-read int|null $requests_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member whereContactNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member whereMiddleName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member whereProgram($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member whereStudentNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member whereYearLevel($value)
 */
	class Member extends \Eloquent {}
}

namespace App\Models{
/**
 * @property-read \App\Models\Member|null $member
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MemberAuth newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MemberAuth newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MemberAuth query()
 */
	class MemberAuth extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $publisher_name
 * @property string|null $publication_origin
 * @property string|null $publication_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\BookData> $bookData
 * @property-read int|null $book_data_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Publisher newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Publisher newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Publisher query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Publisher whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Publisher whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Publisher wherePublicationOrigin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Publisher wherePublicationType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Publisher wherePublisherName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Publisher whereUpdatedAt($value)
 */
	class Publisher extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\passkeyFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|passkey newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|passkey newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|passkey query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|passkey whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|passkey whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|passkey whereUpdatedAt($value)
 */
	class passkey extends \Eloquent {}
}

