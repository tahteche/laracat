@extends('master')
@section('header')
  <h2>About this Site</h2>
@stop

@section('content')
  <p>There are over {{{$number_of_cats}}} cats on this site!</p>
@stop