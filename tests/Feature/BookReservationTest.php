<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Book;

class BookReservationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_book_can_be_added_to_the_library() {
        $this->withoutExceptionHandling();

        $response = $this->post('/books', [
            'title' => 'cool book title',
            'author' => 'abu'
        ]);

        $response->assertOk();

        $this->assertCount(1, Book::all());
    }

    public function test_a_title_is_required() {

        $response = $this->post('/books', [
            'title' => '',
            'author' => 'abu'
        ]);

        $response->assertSessionHasErrors('title');
    }

    public function test_a_author_is_required() {

        $response = $this->post('/books', [
            'title' => 'test title',
            'author' => ''
        ]);

        $response->assertSessionHasErrors('author');
    }

    public function test_a_book_can_be_updated() {
        $this->withoutExceptionHandling();
        $this->post('/books', [
            'title' => 'cool title',
            'author' => 'abu'
        ]);

        $book = Book::first();

        $response = $this->patch('/books/'.$book->id, [
            'title' => 'new title',
            'author' => 'new author'
        ]);

        $this->assertEquals('new title', Book::first()->title);
        $this->assertEquals('new author', Book::first()->author);
    }
}
