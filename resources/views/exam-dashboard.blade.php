@extends('layout.exam-dashboard-layout')

@section('work-space')

@php
    $time = explode(':',$exam[0]->time);
@endphp

<div class="container">
    <h1 class="text-center mt-4" style="font-size: 40px">{{ $exam[0]->examName }}</h1>
    
    @php $qcount = 1; @endphp
    @if($status == true)
        @if(count($qna) > 0)
            <h4 class="text-end time">{{ $exam[0]->time }}</h4>

            {{-- <form action="{{route('account.examSubmit')}}" method="POST" class="mb-5" onsubmit="return isValid()"> --}}
            <form action="{{route('account.examSubmit')}}" method="POST" class="mb-5" id="exam_form">
                @csrf
                <input type="hidden" name="exam_id" value="{{$exam[0]->id}}">
                
                @foreach ($qna as $dt)
                    <div>
                        <h5><b>Q.{{$qcount++}}. {{ $dt->questions[0]->question }}</b></h5>
                        <input type="hidden" name="q[]" value="{{$dt->questions[0]->id}}">
                        <input type="hidden" name="ans_{{$qcount-1}}" id="ans_{{$qcount-1}}">
                        @php $acount = 1; @endphp
                        @foreach ($dt->questions[0]->answers as $answer)
                            {{-- <p> <input type="radio" class="select_ans" data-id="{{$qcount-1}}" name="radio_{{$qcount-1}}" value="{{$answer->id}}"> <b>{{$acount++}})</b> {{$answer->answer}}</p> --}}
                            <p> <input type="radio" class="select_ans" data-id="{{$qcount-1}}" value="{{$answer->id}}"> <b>{{$acount++}})</b> {{$answer->answer}}</p>
                        @endforeach
                    </div>
                    <br>
                @endforeach

                <div class="text-center">
                    <input type="submit" class="btn btn-info">
                </div>
            </form>

        @else
            <h3 class="text-center" style="color: red">Questions and Answers are not Available </h3>
        @endif
    @else
        <h3 class="text-center" style="color: red">{{ $msg }}</h3>
    @endif
</div>

<script>

    $(document).ready(function(){

        $('.select_ans').click(function(){
            var no = $(this).data('id');
            $('#ans_'+no).val($(this).val());
        });

        var time = @json($time);
        var seconds = 3;
        var hours = parseInt(time[0]);
        var minutes = parseInt(time[1]);
        let tempHours;
        let tempMinutes;
        let tempSeconds;
        tempHours = hours.toString().length>1?hours:'0'+hours;
        tempMinutes = minutes.toString().length>1?minutes:'0'+minutes;
        tempSeconds = seconds.toString().length>1?seconds:'0'+seconds;
        $('.time').text(tempHours+':'+tempMinutes+':'+tempSeconds+' Time Left');
        

        var timer = setInterval(() => {
            if(hours==0 && minutes==0 && seconds==0){
                clearInterval(timer);
                $('#exam_form').submit();
            }
            if(seconds <= 0 && minutes!=0){
                minutes--;
                seconds = 59;
            }
            if(minutes <= 0 && hours!=0){
                hours--;
                minutes = 59;
                seconds = 59;
            }

            tempHours = hours.toString().length>1?hours:'0'+hours;
            tempMinutes = minutes.toString().length>1?minutes:'0'+minutes;
            tempSeconds = seconds.toString().length>1?seconds:'0'+seconds;
            $('.time').text(tempHours+':'+tempMinutes+':'+tempSeconds+' Time Left');

            seconds--;

        }, 1000);

        

        

    });


    // function isValid(){
    //     var result = true;

    //     var qlength = parseInt("{{$qcount}}")-1; 
    //     $('.error_msg').remove();

    //     for(let i=1;i<=qlength;i++){
    //         if($('#ans_'+i).val()==""){
    //             result = false;
    //             $('#ans_'+i).parent().append('<span style="color:red;" class="error_msg">Please select answer</span>');
    //             setTimeout(() => {
    //                 $('.error_msg').remove();
    //             }, 5000);
    //         }
    //     }

    //     return result;
    // }


</script>
    

@endsection