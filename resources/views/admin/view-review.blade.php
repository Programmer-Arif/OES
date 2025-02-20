@extends('admin.layout.admin-dashboard-layout')

@section('work-space')

<div>
    <div id="alertdiv" class="mx-5 mt-2 px-3" style="height: 30px">
        <div id="alertmessage" style="display: none">

        </div>   
    </div>
    <br>
    <div class="m-5 mt-0 p-3">
        <h1>Exam Review</h1>
    
        <div id="examsReviewContainer">

        </div>
    </div>


    {{-- Review exam  modal --}}
    <div class="modal fade" id="reviewExamModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="reviewExamModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div id="alertdivinnerreview" class="mx-1 mt-1 px-1" style="height: 20px">
                    <div id="alertmessageinnerreview" style="display: none">
            
                    </div>   
                </div>
                <form method="POST" id="reviewExamForm">
                    @csrf
                    <input type="hidden" name="attempt_id" id="attempt_id">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="reviewExamModalLabel">Review Exam</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Loading...
                        

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary approved-btn">Approve</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


   
</div>

<script>
    
    $(document).ready(function(){

        function loadData() {
            var idNum=1;
            $.ajax({
                url:"{{ route('admin.listExamReview') }}",
                type:"GET",
                success:function(data){
                    if(data.status==true){
                        var allExamsAttempt = data.data;
                
                        var tabledata = `<table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Student Name</th>
                                    <th scope="col">Exam Name</th>
                                    <th scope="col">Subject</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Review</th>
                                </tr>
                            </thead>
                            <tbody>`;

                            if(allExamsAttempt.length>0){
                                allExamsAttempt.forEach(examattempt => {

                                tabledata += `<tr>
                                    <td><h6>${idNum++}</h6></td>
                                    <td><h6>${examattempt.user.name}</h6></td>
                                    <td><h6>${examattempt.exam.examName}</h6></td>
                                    <td><h6>${examattempt.exam.subject.subjectName}</h6></td>`;
                                    if(examattempt.status==false){
                                        tabledata += `<td><h6><span style='color:red;'>Pending</span></h6></td>`;
                                    }else{
                                        tabledata += `<td><h6><span style='color:green;'>Approved</span></h6></td>`;
                                    }        
                                    if(examattempt.status==false){
                                        tabledata += `<td><a href='#' data-bs-examattemptid="${examattempt.id}" data-bs-toggle="modal" data-bs-target="#reviewExamModal">Review & Approve</a></td>`;
                                    }else{
                                        tabledata += `<td><h6><span style='color:green;'>Completed</span></h6></td>`;
                                    }        
                                    
                                tabledata += `</tr>`;
                            });
                            } 
                            else{
                                tabledata += `<tr>
                                    <td colspan="6"><h3 class="text-center">No Exam Added</h3></td>
                                </tr>`;
                            }

                        tabledata += `</tbody>
                                    </table>`;

                        $('#examsReviewContainer').html(tabledata);
                    }
                }
            })
        }
        loadData();


        // Show Review exam  modal on click of Review & approve 
        const reviewModal = $('#reviewExamModal');
        if (reviewModal) {
            $('#reviewExamModal').on( "show.bs.modal",reviewModal, function(event) {

                // Button that triggered the modal
                const button = event.relatedTarget;

                // Extract info from data-bs-* attributes
                const id = button.getAttribute('data-bs-examattemptid');
                $('#attempt_id').val(id);

                $.ajax({
                    url:"{{ route('admin.reviewQNA') }}",
                    type:"GET",
                    data:{'attempt_id':id},
                    success:function(data){
                        if(data.status==true){
                            var idNum=1;
                            var alldata = data.data;
                            var html = '';

                                if(alldata.length>0){
                                    
                                    alldata.forEach(data => {

                                        let isCorrect = '<span style="color:red;" class="fa fa-close"></span>';
                                        if(data.answers.is_correct == true){
                                            isCorrect = '<span style="color:green;" class="fa fa-check"></span>';

                                        }

                                        html += `<div class="row">
                                                    <div class="col-sm-12">
                                                        <h6>Q(${idNum++}). ${data.question.question}</h6>
                                                        <p>Ans:-${data.answers.answer} ${isCorrect}</p>
                                                    </div>
                                                </div>`;

                                    });
                                } 
                                else{
                                    html += `
                                        <h5>Student not attempted any question!</h5>
                                        <p>If you approve this exam student will fail</p>
                                    `;
                                }

                            $('#reviewExamModal .modal-body').html(html);
                        }
                    }
                })


            } );
        }




        $('#reviewExamForm').submit(function(e){
            e.preventDefault();
            $('.approved-btn').html('Please wait <i class="fa fa-spinner fa-spin"></i>');
            var formData = $(this).serialize();
            $.ajax({
                url:"{{ route('admin.approvedQNA') }}",
                type:"POST",
                data:formData,
                success:function(data){
                    var type="";
                    if(data.status==true){
                        $('#reviewExamForm').trigger("reset");
                        $('#reviewExamModal').modal('toggle');
                        loadData();
                        type="alert-success";
                        var elem = `<div class="alert ${type} mb-0" role="alert">${data.message}</div>`;
                        $('#alertmessage').html(elem).fadeIn('slow');
                        // setTimeout(() => {
                        //     $('#alertmessage').fadeOut('slow');
                        // }, 2000);
                    }
                    else{
                        type="alert-danger";
                        var elem = `<div class="alert ${type} mb-0" role="alert" style="padding:3px 10px;">${data.message}</div>`;
                        $('#alertmessageinnerreview').html(elem).fadeIn('slow');
                        setTimeout(() => {
                            $('#alertmessageinnerreview').fadeOut('slow');
                        }, 2000);
                    }
                }
            })
        })

        


    });


</script>



@endsection