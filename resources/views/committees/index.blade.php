@extends('layout.one-column-layout')

@section('content')
  <h2 class="section-header section-header--centered">
    Committees
  </h2>

  <div class="row">
      @foreach ($committees as $committee)
          @component('committees._committee')
          @slot('name')
          {{ $committee->name }}
          @endslot

          @slot('link')
              {{  action([\Francken\Association\Committees\Http\CommitteesController::class, 'show'], ['board' => $committee->board, 'committee' => $committee]) }}
          @endslot

          @slot('logo')
          {{ $committee->logo }}
          @endslot
          @endcomponent
      @endforeach
  </div>
 @endsection
