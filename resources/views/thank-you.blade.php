@extends('layout.exam-dashboard-layout')

@section('work-space')

<div class="container">
    <div class="text-center">
        <h2>Thanks for submitting the exam, {{ Auth::user()->name }}</h2>
        <p>We will review your exam and update you soon by mail</p>
        <a href="/account/dashboard" class="btn btn-info">Go Back</a>
    </div>
</div>

<script>

   


</script>
    

@endsection