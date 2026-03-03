<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Author;
use App\Models\Book;
use App\Models\Student;
use App\Models\Borrow;
use App\Models\BorrowItem;
use Carbon\Carbon;

class LibrarySeeder extends Seeder
{
    public function run(): void
    {
        // Create Authors
        $authors = [
            ['name' => 'William Shakespeare'],
            ['name' => 'Jane Austen'],
            ['name' => 'Charles Dickens'],
            ['name' => 'Mark Twain'],
            ['name' => 'J.K. Rowling'],
            ['name' => 'Stephen King'],
            ['name' => 'Agatha Christie'],
            ['name' => 'George Orwell'],
            ['name' => 'J.R.R. Tolkien'],
            ['name' => 'Harper Lee'],
        ];

        foreach ($authors as $author) {
            Author::create($author);
        }

        // Create Books
        $books = [
            [
                'title' => 'Romeo and Juliet',
                'isbn' => '978-0143107317',
                'total_quantity' => 5,
                'available_quantity' => 5,
                'authors' => ['William Shakespeare']
            ],
            [
                'title' => 'Pride and Prejudice',
                'isbn' => '978-0141439518',
                'total_quantity' => 3,
                'available_quantity' => 2,
                'authors' => ['Jane Austen']
            ],
            [
                'title' => 'Great Expectations',
                'isbn' => '978-0141439563',
                'total_quantity' => 4,
                'available_quantity' => 3,
                'authors' => ['Charles Dickens']
            ],
            [
                'title' => 'Adventures of Huckleberry Finn',
                'isbn' => '978-0143107613',
                'total_quantity' => 6,
                'available_quantity' => 4,
                'authors' => ['Mark Twain']
            ],
            [
                'title' => 'Harry Potter and the Sorcerer\'s Stone',
                'isbn' => '978-0439708180',
                'total_quantity' => 10,
                'available_quantity' => 7,
                'authors' => ['J.K. Rowling']
            ],
            [
                'title' => 'The Shining',
                'isbn' => '978-0307743657',
                'total_quantity' => 3,
                'available_quantity' => 2,
                'authors' => ['Stephen King']
            ],
            [
                'title' => 'Murder on the Orient Express',
                'isbn' => '978-0007119318',
                'total_quantity' => 4,
                'available_quantity' => 3,
                'authors' => ['Agatha Christie']
            ],
            [
                'title' => '1984',
                'isbn' => '978-0451524935',
                'total_quantity' => 8,
                'available_quantity' => 5,
                'authors' => ['George Orwell']
            ],
            [
                'title' => 'The Hobbit',
                'isbn' => '978-0345339683',
                'total_quantity' => 7,
                'available_quantity' => 6,
                'authors' => ['J.R.R. Tolkien']
            ],
            [
                'title' => 'To Kill a Mockingbird',
                'isbn' => '978-0061120084',
                'total_quantity' => 5,
                'available_quantity' => 4,
                'authors' => ['Harper Lee']
            ],
        ];

        foreach ($books as $bookData) {
            $book = Book::create([
                'title' => $bookData['title'],
                'isbn' => $bookData['isbn'],
                'total_quantity' => $bookData['total_quantity'],
                'available_quantity' => $bookData['available_quantity'],
            ]);

            // Attach authors
            foreach ($bookData['authors'] as $authorName) {
                $author = Author::where('name', $authorName)->first();
                if ($author) {
                    $book->authors()->attach($author->id);
                }
            }
        }

        // Create Students
        $students = [
            [
                'student_number' => '2021-001',
                'full_name' => 'John Smith',
                'course' => 'Computer Science',
                'year_level' => '3rd Year'
            ],
            [
                'student_number' => '2021-002',
                'full_name' => 'Emily Johnson',
                'course' => 'Information Technology',
                'year_level' => '2nd Year'
            ],
            [
                'student_number' => '2020-003',
                'full_name' => 'Michael Brown',
                'course' => 'Computer Engineering',
                'year_level' => '4th Year'
            ],
            [
                'student_number' => '2022-004',
                'full_name' => 'Sarah Davis',
                'course' => 'Information Systems',
                'year_level' => '1st Year'
            ],
            [
                'student_number' => '2021-005',
                'full_name' => 'David Wilson',
                'course' => 'Computer Science',
                'year_level' => '3rd Year'
            ],
        ];

        foreach ($students as $studentData) {
            Student::create($studentData);
        }

        // Create some sample borrows
        $studentJohn = Student::where('student_number', '2021-001')->first();
        $studentEmily = Student::where('student_number', '2021-002')->first();
        $studentMichael = Student::where('student_number', '2020-003')->first();

        $bookHarry = Book::where('isbn', '978-0439708180')->first();
        $book1984 = Book::where('isbn', '978-0451524935')->first();
        $bookPride = Book::where('isbn', '978-0141439518')->first();
        $bookHobbit = Book::where('isbn', '978-0345339683')->first();

        // Active borrow (John Smith - overdue)
        $borrow1 = Borrow::create([
            'student_id' => $studentJohn->id,
            'borrow_date' => Carbon::now()->subDays(20),
            'due_date' => Carbon::now()->subDays(7),
            'status' => 'borrowed',
        ]);

        BorrowItem::create([
            'borrow_id' => $borrow1->id,
            'book_id' => $bookHarry->id,
            'quantity' => 2,
            'returned_quantity' => 0,
        ]);

        // Update available quantity
        $bookHarry->decrement('available_quantity', 2);

        // Partially returned borrow (Emily Johnson)
        $borrow2 = Borrow::create([
            'student_id' => $studentEmily->id,
            'borrow_date' => Carbon::now()->subDays(15),
            'due_date' => Carbon::now()->addDays(2),
            'status' => 'partially_returned',
        ]);

        BorrowItem::create([
            'borrow_id' => $borrow2->id,
            'book_id' => $book1984->id,
            'quantity' => 3,
            'returned_quantity' => 1,
        ]);

        // Update available quantity
        $book1984->decrement('available_quantity', 2);

        // Completed borrow (Michael Brown)
        $borrow3 = Borrow::create([
            'student_id' => $studentMichael->id,
            'borrow_date' => Carbon::now()->subDays(30),
            'due_date' => Carbon::now()->subDays(15),
            'status' => 'returned',
        ]);

        BorrowItem::create([
            'borrow_id' => $borrow3->id,
            'book_id' => $bookPride->id,
            'quantity' => 1,
            'returned_quantity' => 1,
        ]);

        BorrowItem::create([
            'borrow_id' => $borrow3->id,
            'book_id' => $bookHobbit->id,
            'quantity' => 2,
            'returned_quantity' => 2,
        ]);
    }
}
