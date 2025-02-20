@extends('layout.dashboard-layout')

@section('work-space')

<div>
    <div class="m-5 mt-0 p-3">
        
        
        <h1>Exam Review</h1>
       
    
        {{-- Review exam  modal --}}
        <div class="modal fade" id="reviewExamModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="reviewExamModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div id="alertdivinnerreview" class="mx-1 mt-1 px-1" style="height: 20px">
                        <div id="alertmessageinnerreview" style="display: none">
                
                        </div>   
                    </div>
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="reviewExamModalLabel">Review Exam</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Loading...
                        

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div> 
                </div>
            </div>
        </div>

        {{-- Explaination  modal --}}
        <div class="modal fade" id="explainationModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="explainationModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="explainationModalLabel">Explaination</h1>
                        <button type="button" class="btn-close attempt_attr" data-bs-toggle="modal" data-bs-target="#reviewExamModal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p id="explaination"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary attempt_attr" data-bs-toggle="modal" data-bs-target="#reviewExamModal">Close</button>
                    </div> 
                </div>
            </div>
        </div>
    
        
        <table class="table">
            <thead>
                <th>#</th>
                <th>Exam Name</th>
                <th>Subject</th>
                <th>Result</th>
                <th>Status</th>
            </thead>
            <tbody>
                @if(count($attempts) > 0)
                    @php
                        $idNum=1;   
                    @endphp
                    @foreach ($attempts as $attempt)
                        <tr>
                            <td style="display: none"><h6>{{ $attempt->id }}</h6></td>
                            <td><h6>{{ $idNum++ }}</h6></td>
                            <td><h6>{{ $attempt->exam->examName }}</h6></td>
                            <td><h6>{{ $attempt->exam->subject->subjectName }}</h6></td>
                            <td>@if($attempt->status == false)
                                    <h6 style="color:orange">Not Declared</h6>
                                @else
                                    @if($attempt->marks >= $attempt->exam->passing_marks)
                                        <h6 style="color:green">Passed</h6>
                                    @else
                                        <h6 style="color:red">Failed</h6>   
                                    @endif   
                                @endif
                            </td>
                            <td>
                                @if($attempt->status == false)
                                    <h6 style="color:orange">Pending</h6>
                                @else
                                    <h6 style="color:blue"><a href="#" data-id={{ $attempt->id }} data-bs-toggle="modal" data-bs-target="#reviewExamModal">Review Q&A</a></h6>
                                @endif
                            </td>
                            
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5"><h3 class="text-center">Exam not attempted</h3></td>
                    </tr>
                @endif

            </tbody>
        </table>

    </div>


</div>

<script>
    
        // Show Review exam  modal on click of Review & approve 
        const reviewModal = $('#reviewExamModal');
        if (reviewModal) {
            $('#reviewExamModal').on( "show.bs.modal",reviewModal, function(event) {

                // Button that triggered the modal
                const button = event.relatedTarget;

                // Extract info from data-bs-* attributes
                const id = button.getAttribute('data-id');

                $.ajax({
                    url:"{{ route('account.stuReviewQNA') }}",
                    type:"GET",
                    data:{'attempt_id':id},
                    success:function(data){
                        if(data.status==true){
                            var idNum=1;
                            var alldata = data.data;
                            var html = '';

                                if(alldata.length>0){
                                    
                                    alldata.forEach(data => {
                                        
                                        // console.log(data);
                                        let isCorrect = '<span style="color:red;" class="fa fa-close"></span>';
                                        if(data.answers.is_correct == true){
                                            isCorrect = '<span style="color:green;" class="fa fa-check"></span>';

                                        }

                                        var correctAns = "";
                                        (data.question.answers).forEach(answer => {
                                            if(answer.is_correct == true && data.answers.is_correct == false){
                                                correctAns = '<u>Correct Ans: </u>' + answer.answer;
                                            }
                                        });

                                        

                                        html += `<div class="row">
                                                    <div class="col-sm-12">
                                                        <h6><b>Q(${idNum}).</b> ${data.question.question}</h6>
                                                        <h6><u>Your Ans: </u>${data.answers.answer} ${isCorrect}</h6>
                                                        <h6>${correctAns}</h6>`;
                                                        if(data.question.explaination != null){

                                                            html += `<h6><a href="#" data-attempt=${id} data-question-num="${idNum}" data-expl="${data.question.explaination}" data-bs-toggle="modal" data-bs-target="#explainationModal">Explaination</a></h6>`;
                                                        }
                                                html +=  `</div>
                                                        </div>`;
                                        idNum++;

                                    });
                                } 
                                else{
                                    html += `
                                        <h5>You haven't attempted any question!</h5>
                                    `;
                                }

                            $('#reviewExamModal .modal-body').html(html);
                        }
                    }
                })


            } );
        }



        // Show Explaination modal on click of Explaination inside review modal 
        const explainationModal = $('#explainationModal');
        if (explainationModal) {
            $('#explainationModal').on( "show.bs.modal",explainationModal, function(event) {

                // Button that triggered the modal
                const button = event.relatedTarget;
                // Extract info from data-bs-* attributes
                const attempt_id = button.getAttribute('data-attempt');
                const question_num = button.getAttribute('data-question-num');
                console.log(question_num);
                const expl = button.getAttribute('data-expl');

                $('#explainationModalLabel').text('Elplaination of Q.' + question_num +'.');
                $('#explaination').text(expl);
                $('.attempt_attr').attr('data-id',attempt_id);


            } );
        }

</script>



@endsection