<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BooksController extends Controller
{
    public function store()
    {
        $data = request()->validate([
            'title' => 'required',
            'author' => 'required'
        ]);

        $book = Book::create($data);

        return redirect()->to($book->path());
    }

    public function update(Book $book)
    {
        $data = request()->validate([
            'title' => 'required',
            'author' => 'required'
        ]);

        $book->update($data);

        return redirect()->to($book->path());
    }

    public function destroy(Book $book)
    {
        $book->delete();

        return redirect()->to('/books');
    }
}
