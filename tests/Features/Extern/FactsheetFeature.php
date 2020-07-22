<?php

declare(strict_types=1);

namespace Francken\Features\Extern;

use Francken\Association\Boards\Board;
use Francken\Extern\Http\FactSheetController;
use Francken\Features\LoggedInAsAdmin;
use Francken\Features\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class FactsheetFeature extends TestCase
{
    use DatabaseMigrations;
    use LoggedInAsAdmin;

    /** @test */
    public function a_factsheet_is_shown() : void
    {
        $board = factory(Board::class)->create(['installed_at' => '2020-06-06']);
        $this->visit(action([FactSheetController::class, 'index']));

        $this->assertResponseOk();
    }
}