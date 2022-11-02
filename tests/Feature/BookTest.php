<?php

namespace Tests\Feature;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_get_all_books()
    {

        $books = Book::factory(4)->create();

        $response = $this->getJson(route('books.index'));

        $response->assertJsonFragment([
            'title', $books[0]->title
        ])->assertJsonFragment([
            'title' => $books[1]->title
        ]);
    }

    /** @test */
    public function can_get_one_book()
    {
        $book = Book::factory()->create();

        $response = $this->getJson(route('books.show', $book))
            ->assertJsonFragment([
                'title' => $book->title,
        ]);
    }

    /** @test */
    public function can_create_book()
    {

        //$this->postJson(route('books.store'), []);

        $this->postJson(route('books.store'), [
            'title' => 'Create book',
        ])->assertJsonFragment([
            'title' => 'Create book'
        ]);

        $this->assertDatabaseHas('books', [
            'title' => 'Create book'
        ]);
    }

    /** @test */
    public function can_update_book()
    {

        $book = Book::factory()->create();

        $this->patchJson(route('books.update', $book), []);

        $this->patchJson(route('books.update', $book), [
            'title' => 'Update book',
        ])->assertJsonFragment([
            'title' => 'Update book'
        ]);

        $this->assertDatabaseHas('books', [
            'title' => 'Update book'
        ]);
    }

    /** @test */
    public function can_delete_book()
    {

        $book = Book::factory()->create();

        $this->deleteJson(route('books.destroy', $book))
            ->assertNoContent();

        $this->assertDatabaseCount('books', 0);
    }

}
