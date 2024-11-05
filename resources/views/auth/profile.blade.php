<!-- resources/views/profile.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ __('Your Profile') }}</h1>
    <div class="card mt-4">
        <div class="card-body">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th scope="row">{{ __('Name') }}</th>
                        <td>{{ Auth::user()->name }}</td>
                    </tr>
                    <tr>
                        <th scope="row">{{ __('Email') }}</th>
                        <td>{{ Auth::user()->email }}</td>
                    </tr>
                    <tr>
                        <th scope="row">{{ __('Account Created') }}</th>
                        <td>{{ Auth::user()->created_at->format('F d, Y') }}</td>
                    </tr>
                    <tr>
                        <th scope="row">{{ __('Last Updated') }}</th>
                        <td>{{ Auth::user()->updated_at->format('F d, Y') }}</td>
                    </tr>
                    <!-- Add more rows as needed -->
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
