@extends('layout.layout')

@section('title', "T.F.V. 'Professor Francken'")
@section('description', "‘Professor Francken’ is the study association for Engineering Physics, connected to the University of Groningen. It is named after Groningen’s first professor of Applied Physics and is for students and staff of the applied physics departments.")

@section('main-content')
    <div class="mt-5">
    @include("homepage._about-francken")

    @include("homepage._news")

    @include("homepage._pillars")
    </div>
@endsection

@section('header-image')
    @include("layout.header._registration-cta")
@endsection
