@extends('layout.dashboard-layout')

@section('work-space')

<div>
    <div class="m-5 mt-0 p-3">
        <h1>Free Exams</h1>
        
        <table class="table">
            <thead>
                <th>#</th>
                <th>Exam Name</th>
                <th>Subject</th>
                <th>Date</th>
                <th>Time</th>
                <th>Total Attempt</th>
                <th>Have Attempted</th>
                <th>Copy Link</th>
            </thead>
            <tbody>
                @if(count($exams) > 0)
                    @php
                        $idNum=1;   
                    @endphp
                    @foreach ($exams as $exam)
                        <tr>
                            <td style="display: none"><h6>{{ $exam->id }}</h6></td>
                            <td><h6>{{ $idNum++ }}</h6></td>
                            <td><h6>{{ $exam->examName }}</h6></td>
                            <td><h6>{{ $exam->subject->subjectName }}</h6></td>
                            <td><h6>{{ $exam->date }}</h6></td>
                            <td><h6>{{ $exam->time }} Hrs</h6></td>
                            <td><h6>{{ $exam->no_of_attempts_possible }}</h6></td>
                            <td><h6>{{ $exam->attempt_counter }}</h6></td>
                            
                            <td><a href="#" data-code="{{ $exam->entrance_id }}" class="copy"> <i class="fa fa-copy"></i> </a></td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="8"><h3 class="text-center">No Exam Available</h3></td>
                    </tr>
                @endif

            </tbody>
        </table>

    </div>


</div>

<script>
    $(document).ready(function(){

        $('.copy').click(function(){
            $(this).parent().append('<span style="color:#0a58ca;font-weight:bold;" class="copied_text">copied</span>');

            var code = $(this).attr('data-code');
            var url = `{{URL::to('/')}}/account/exam/${code}`;

            var $temp = $("<input>");
            $('body').append($temp);
            $temp.val(url).select();
            document.execCommand("copy");
            $temp.remove();

            setTimeout(() => {
                $('.copied_text').remove();
            }, 1000);
        });



    });


</script>



@endsection