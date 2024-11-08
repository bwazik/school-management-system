@extends('layouts.master')

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('assets/vendor/libs/bs-stepper/bs-stepper.css') }}" />
    @livewireStyles
@endsection

@section('pageTitle')
    {{ trans('layouts/sidebar.parents') }} - {{ trans('layouts/sidebar.program') }}
@endsection

@section('breadcrumb1')
    {{ trans('layouts/sidebar.users') }}
@endsection

@section('breadcrumb2')
    {{ trans('layouts/sidebar.parents') }}
@endsection

@section('content')
    <div class="row">
        @livewire('users.EditParent', ['id' => $id])
    </div>
@endsection

@section('js')
    @livewireScripts

    <script>
        @if (Session::has('edited'))
            toastr.success('{{ Session::get('edited') }}');
        @endif
    </script>
@endsection
