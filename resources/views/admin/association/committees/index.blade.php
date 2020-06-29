@extends('admin.layout')
@section('page-title', 'Committees')

@section('content')
    <div class="card">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th colspan="2">Committee</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($committees as $committee)
                    <tbody>
                        <tr class=" border-bottom-0">
                            <td style="width: 200px;" class="align-middle">
                                <img
                                    class="rounded ml-2 my-2"
                                    src="{{ $committee->logo }}"
                                    alt="Logo of {{ $committee->name }}"
                                    style="
                                           width: 150px;
                                           max-width: 150px;
                                           max-height: 80px;
                                           object-fit: cover;"
                                />
                            </td>
                            <td>
                                <a href="{{ action(
                                            [\Francken\Association\Committees\Http\AdminCommitteesController::class, 'show'],
                                            ['committee' => $committee, 'board_id' => $selected_board_id]
                                            ) }}"
                                >
                                    <h4 class='d-flex flex-column h6'>
                                        <span>
                                            {{ $committee->name }}
                                        </span>
                                        <small class="text-muted mt-1">
                                            Last updated
                                            {{ $committee->updated_at->diffForHumans() }}
                                        </small>
                                    </h4>
                                </a>
                                    <small class="mt-1">
                                        <a class="text-muted" href="malto: {{ $committee-> email }}">
                                            {{ $committee->email }}
                                        </a>
                                    </small>
                            </td>
                        </tr>
                        <tr class="border-top-0">
                            <td colspan="2" class="border-top-0 bg-light">
                                @foreach ($committee->committeeMembers() as $member)
                                    <span class="badge badge-light bg-white font-weight-light font-weight-light">

                                        {{ $member->member->full_name }}
                                        @unless ($selected_board)
                                            ({{ $member->board_year }})
                                        @endunless
                                    </span>
                                @endforeach
                            </td>
                        </tr>
                    </tbody>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('actions')
    <div class="d-flex align-items-start">

        {!!
           Form::open(
               [
                   'url' => action(
                       [\Francken\Association\Committees\Http\AdminCommitteesController::class, 'index']
                   ),
                   'method' => 'get',
                   'class' => 'form-inline mr-3',
               ]
           )
        !!}
        <div class="form-group mr-3">
            <label for="board_id" class="mx-3">Board</label>
            {!!
               Form::select('board_id', $board_years, $selected_board_id, ['class' => 'form-control', 'id' => 'board_id']);
            !!}
        </div>
        <button class='btn btn-primary btn-sm'>
            <i class="fas fa-eye"></i>
            View
        </button>
        {!! Form::close() !!}

        <a href="{{ action([\Francken\Association\Committees\Http\AdminCommitteesController::class, 'create']) }}"
           class="btn btn-primary btn-sm"
        >
            <i class="fas fa-plus"></i>
            Add a committee
        </a>
    </div>
@endsection