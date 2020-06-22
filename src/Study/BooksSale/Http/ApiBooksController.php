<?php

declare(strict_types=1);

namespace Francken\Study\BooksSale\Http;

use Francken\Study\BooksSale\AvailableBooks\AvailableBook;
use Francken\Study\BooksSale\AvailableBooks\AvailableBooksRepository;

final class ApiBooksController
{
    public function index(AvailableBooksRepository $books)
    {
        return [
            'books' => collect($books->findAll())->map(
                function (AvailableBook $book) {
                    return [
                        'title' => $book->title(),
                        'author' => $book->author(),
                        'isbn' => $book->isbn(),
                        'cover' => $book->pathToCover(),
                        'price_in_cents' => $book->price(),
                    ];
                })->values()
        ];
    }
}
