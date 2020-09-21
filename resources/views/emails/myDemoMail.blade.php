@extends('layout.master')
@section('content')
<h1>This is your all user Data</h1>
@component('mail::table')
<table class="table" style="text-align: center;">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Name</th>
      <th scope="col">Email</th>
      <th scope="col">Type</th>
    </tr>
  </thead>
  <tbody>
   @foreach($users as $user)
    <tr>
      <th scope="row">{{ $loop->iteration }}</th>
      <td>{{ $user->name }}</td>
      <td>{{ $user->email }}</td>
      <td>{{ $user->type }}</td>
    </tr>
   @endforeach
  </tbody>
</table>
@endcomponent
@endsection
