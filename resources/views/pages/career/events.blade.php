@extends('pages.career')
@section('title', "Career events - T.F.V. 'Professor Francken'")

<?php
$plannedExcursions = [
    [
        'name' => 'Excursion to Tata Steel',
        'promo-image' => 'https://upload.wikimedia.org/wikipedia/commons/d/de/CORUS-02.jpg',
        'date' => 'September 14th 2017',
        'description' => null,
        'metadata' => [
            ['term' => 'Expected number of participants', 'description' => '30'],
            ['term' => 'In collabortaion with', 'description' => '<a href="https://www.gtdbernoulli.nl">G.T.D Bernoulli</a> '],
            ['term' => 'Location', 'description' => 'Ijmuiden'],
            ['term' => 'Expected Date', 'description' => 'September 14th 2017'],
        ]
    ], [
        'name' => 'Material Science excursion',
        'promo-image' => 'http://www.rsp-technology.com/site-media/elements/pictures/header-rsp.jpg',
        'date' => 'September 24th 2017',
        'description' => 'In collaboration with prof. dr. ir. B. J. Kooi an excursion is organised for students attending the coarse Material Science. We will visit two companies, Klesch and RSP both located in Delfzijl.',
        'metadata' => [
            ['term' => 'Expected number of participants', 'description' => '80'],
            ['term' => 'Location', 'description' => 'Delfzijl'],
            ['term' => 'Expected Date', 'description' => 'September 24th 2017'],
        ]
    ], [
        'name' => 'Excursion to Shell',
        'promo-image' => 'http://www.nwtr.nl/images/content/aanvoerwater.jpg',
        'date' => 'Second term of 2017 - 2018',
        'description' => null,
        'metadata' => [
            ['term' => 'Location', 'description' => 'Emmen'],
            ['term' => 'Expected Date', 'description' => 'Second term of 2017 - 2018'],
        ]
    ], [
        'name' => 'Lunch lecture Lambert Instruments',
        'promo-image' => '',
        'date' => 'November 2017',
        'description' => "In November Wopke Hellinga, a recent alumnus of T.F.V. 'Professor Francken' and active member of the Brouwcie, will show us what he's been working on at Lambert Instruments.",
        'metadata' => [
            ['term' => 'Expected Date', 'description' => 'November 2017'],
        ]
    ]
];
?>

@section('board-year-navigation')
    <ol class="list-inline academic-year-list">
        <li class="list-inline-item">

            {{-- Check if current $year is the current year --}}

            @if ($showNextYear)
            <a href="/career/events/{{ str_slug($year->nextYear()->toString()) }}" class="academic-year-list__item">
                {{ $year->nextYear()->toString() }}
            </a>
            @else
            <a href="#" class="academic-year-list__item academic-year-list__item--disabled" title="Currently we don't have any excursions planned for the academic year of 2018 - 2019">
                {{ $year->nextYear()->toString() }}
            </a>
            @endif
        </li>
        <li class="list-inline-item">

            <strong class="academic-year-list__item academic-year-list__item--active">
                {{ $year->toString() }}
            </strong>
        </li>
        <li class="list-inline-item">
            <a href="/career/events/{{ str_slug($year->previousYear()->toString()) }}" class="academic-year-list__item">

                {{ $year->previousYear()->toString() }}
            </a>
        </li>
    </ol>
@endsection

@section('content')
    <h1 class="section-header section-header--centered" id="excursions">
        Career Events
    </h1>

    <p class="lead">
        At T.F.V. 'Professor Francken' we organize many excursions.
        Below you'll find a list of past and planned excursions for the Academic Year of {{ $year->toString() }} and previously organized excursions.
    </p>

    @yield('board-year-navigation')

    @if (count($plannedEvents) > 0)
        <h2 class="text-center">
            Planned events
        </h2>

        <ul class="list-unstyled">

            @foreach ($plannedEvents as $excursion)
                @include('pages.career._event', ['excursion' => $excursion])
            @endforeach
        </ul>
    @endif

    @if (count($pastEvents) > 0)
        <h2 class="text-center">
            Past events
        </h2>

        <ul class="list-unstyled">

            @foreach ($pastEvents as $excursion)
                @include('pages.career._event', ['excursion' => $excursion])
            @endforeach
        </ul>
    @endif

    @if (count($pastEvents) == 0 && count($plannedEvents) == 0)
        <p class="text-center">
            We don't have any data for this academic year.
        </p>
    @endif

    @yield('board-year-navigation')
@endsection
