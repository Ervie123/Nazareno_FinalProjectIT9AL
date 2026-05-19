@extends('layouts.app')
@section('title', 'Tournament Details')

@section('content')
<div class="page-header">
  <h1>{{ $tournament->name }}</h1>
  <p>{{ $tournament->sport }}</p>
</div>

<div class="data-card">
  <p><strong>Status:</strong> {{ $tournament->status }}</p>
  <p><strong>Teams:</strong> {{ $tournament->teams }}</p>
  <p><strong>Matches:</strong> {{ $tournament->matches }}</p>
  <p><strong>Start:</strong> {{ $tournament->start_date }}</p>
  <p><strong>End:</strong> {{ $tournament->end_date }}</p>
</div>
@endsection