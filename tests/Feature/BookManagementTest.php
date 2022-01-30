<?php

namespace Tests\Feature;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookManagementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_book_can_be_added_to_the_library()
    {
        $response = $this->post('/books', $this->data());

        $this->assertCount(1, Book::all());

        $response->assertRedirect(Book::first()->path());
    }

    /** @test */
    public function a_title_is_required()
    {
        $response = $this->post('/books', [
            'title' => '',
            'author' => 'Nur'
        ]);

        $response->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_author_is_required()
    {
        $response = $this->post('/books', array_merge($this->data(), ['author_id' => '']));

        $response->assertSessionHasErrors('author_id');
    }

    public function testa_book_can_be_updated()
    {
        $this->post('/books', $this->data());

        $book = Book::first();

        $response = $this->patch($book->path(), [
            'title' => 'New Title',
            'author_id' => 'New Author'
        ]);

        $this->assertEquals('New Title', $book->fresh()->title);
        $this->assertEquals(2, $book->fresh()->author_id);
        $response->assertRedirect($book->fresh()->path());
    }

    /** @test */
    public function a_book_can_be_deleted()
    {
        $this->post('/books', $this->data());

        $book = Book::first();
        $this->assertCount(1, Book::all());

        $response = $this->delete($book->path());

        $this->assertNotCount(1, Book::all());

        $response->assertRedirect('/books');
    }

    /** @test */
    public function a_new_author_automatically_added()
    {
        $this->post('/books', [
            'title' => 'Cool Book Title',
            'author_id' => 'Nur'
        ]);

        $book = Book::first();
        $author = Author::first();

        $this->assertEquals($author->id, $book->author_id);
        $this->assertCount(1, Author::all());
    }

    public function data()
    {
        return [
            'title' => 'Cool Book Title',
            'author_id' => 'Nur'
        ];
    }
}
