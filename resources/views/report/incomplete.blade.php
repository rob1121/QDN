@extends('layouts.app')
@section('external-style')
    <link rel="stylesheet" href="/vendor/css/select2.css">
    <link rel="stylesheet" href="/vendor/css/select2-bootstrap.css">
@stop

@include('report.partials.style')

@section('content')
    <div class="container">
        @include('report.partials.header')
        <!-- START OF FORM -->
        <form
            method='POST'
            action="{{ route('draft_link', ['slug' => $qdn->slug]) }}"
            enctype="multipart/form-data"
            id="completion"
            novalidate
        >
            {!! csrf_field() !!}

            @include('report.partials.section', ['hidden' => isHidden($qdn), 'disabled' => isDisabled($qdn)])

            @if (isIncompleteFillUpRespondent($qdn))
                <div class="text-right container" id="btn-group">
                    <button id='draft_button'
                        type='submit'
                        name='draft_button'
                        class="btn btn-default btn-lg"
                    >
                        Save as Draft
                        <span class="fa fa-save"></span>
                    </button>

                    <button id='aprroval_button'
                        type='submit'
                        name='aprroval_button'
                        class="btn btn-default btn-lg btn-primary"
                    >
                        Submit for approvals
                        <span class="fa fa-paper-plane"></span>
                    </button>
                </div>
            @endif
        </form>
    </div>
    @include('report.partials.modal')
@stop

@push('scripts')

    @include('report.partials.script')

@endpush