<?php

declare(strict_types=1);

namespace Francken\Association\Members\Http;

use Francken\Association\Committees\Committee;
use Illuminate\Database\Eloquent\Builder;

final class ProfileController
{
    public function index()
    {
        $member = $this->member(request()->user());

        $committees = Committee::with(['board'])
            ->whereHas('members', function (Builder $query) use ($member) : Builder {
                return $query->where('member_id', $member->id);
            })
            ->get()
            ->sortByDesc(function (Committee $committee) {
                return $committee->board->installed_at;
            });

        return view('profile.index')
            ->with([
                'committees' => $committees,
                'breadcrumbs' => [
                    ['url' => '/profile', 'text' => 'Profile'],
                ]
            ]);
    }

    private function member($user)
    {
        $lid = \DB::connection('francken-legacy')
            ->table('leden')
            ->where('id', $user->member_id)
            ->first();

        $this->profile = $lid;

        return $lid;
    }
}
