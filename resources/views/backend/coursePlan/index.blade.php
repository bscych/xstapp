@extends('layouts.app_backend')

@section('content')
<div id='calendar'></div>
<script>
$( document ).ready(function() {
  $('#calendar').fullCalendar({
    // put your options and callbacks here
  })
});

</script>
@endsection
