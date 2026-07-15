<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\BookData;
use App\Models\Librarian;
use App\Models\MemberAuth;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class MarcImportTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $librarian = Librarian::factory()->create();
        $administrator = MemberAuth::create([
            'librarian_id' => $librarian->librarian_id,
            'username' => 'marc_test_admin',
            'password_hash' => Hash::make('password123'),
            'account_type' => 'Administrator',
            'account_status' => 'Active',
        ]);

        $this->actingAs($administrator, 'member');
    }

    public function test_marcxml_with_a_bom_and_leading_whitespace_can_be_previewed(): void
    {
        $file = UploadedFile::fake()->createWithContent(
            'records.marcxml',
            "\xEF\xBB\xBF\r\n  " . $this->validMarcXml(),
        );

        $response = $this->post(route('admin.books.marc-preview'), [
            'marc_file' => $file,
        ]);

        $response->assertOk();
        $response->assertViewIs('admin.books.marc.preview');
        $response->assertViewHas('batchId');
        $response->assertViewHas('validatedRows', function (array $rows): bool {
            return count($rows) === 1
                && $rows[0]['status'] === 'valid'
                && $rows[0]['parsed']['book_title'] === 'Practical Library Systems'
                && $rows[0]['parsed']['publication_year'] === '2024'
                && $rows[0]['parsed']['call_number'] === 'Z678.9 .D64 2024';
        });
    }

    public function test_preview_rejects_an_unsupported_file_extension(): void
    {
        $file = UploadedFile::fake()->createWithContent('records.txt', $this->validMarcXml());

        $response = $this
            ->from(route('admin.books.marc-create'))
            ->post(route('admin.books.marc-preview'), ['marc_file' => $file]);

        $response->assertRedirect(route('admin.books.marc-create'));
        $response->assertSessionHasErrors('marc_file');
    }

    public function test_confirmed_marc_record_is_imported_with_its_raw_xml(): void
    {
        $preview = $this->post(route('admin.books.marc-preview'), [
            'marc_file' => UploadedFile::fake()->createWithContent(
                'records.xml',
                $this->validMarcXml(),
            ),
        ]);

        $preview->assertOk();
        $batchId = $preview->viewData('batchId');

        $result = $this->post(route('admin.books.marc-store'), [
            'batch_id' => $batchId,
            'accessions' => [0 => 'MARC-0001'],
        ]);

        $result->assertOk();
        $result->assertViewIs('admin.books.marc.result');

        $bookData = BookData::where('book_title', 'Practical Library Systems')->firstOrFail();

        $this->assertNotNull($bookData->marc_record);
        $this->assertStringContainsString('<record', $bookData->marc_record);
        $this->assertDatabaseHas('book_details', [
            'book_data_id' => $bookData->book_data_id,
            'isbn' => '9781234567897',
            'publication_year' => 2024,
            'call_number' => 'Z678.9 .D64 2024',
        ]);
        $this->assertTrue(Book::where('accession_number', 'MARC-0001')->exists());
    }

    private function validMarcXml(): string
    {
        return <<<'XML'
<?xml version="1.0" encoding="UTF-8"?>
<collection xmlns="http://www.loc.gov/MARC21/slim">
    <record>
        <leader>00000nam a2200000 i 4500</leader>
        <controlfield tag="001">test-1</controlfield>
        <controlfield tag="008">260714s2024    xxu           000 0 eng d</controlfield>
        <datafield tag="020" ind1=" " ind2=" ">
            <subfield code="a">9781234567897</subfield>
        </datafield>
        <datafield tag="100" ind1="1" ind2=" ">
            <subfield code="a">Doe, Jane.</subfield>
        </datafield>
        <datafield tag="245" ind1="1" ind2="0">
            <subfield code="a">Practical Library Systems :</subfield>
            <subfield code="b">a MARC import test /</subfield>
        </datafield>
        <datafield tag="264" ind1=" " ind2="1">
            <subfield code="b">Test Press,</subfield>
            <subfield code="c">2024.</subfield>
        </datafield>
        <datafield tag="050" ind1=" " ind2=" ">
            <subfield code="a">Z678.9</subfield>
            <subfield code="b">.D64 2024</subfield>
        </datafield>
        <datafield tag="650" ind1=" " ind2="0">
            <subfield code="a">Library information systems.</subfield>
        </datafield>
    </record>
</collection>
XML;
    }
}
