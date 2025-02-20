@extends('admin.layout.admin-dashboard-layout')

@section('work-space')

<div>
    <div id="alertdiv" class="mx-5 mt-2 px-3" style="height: 30px">
        <div id="alertmessage" style="display: none">

        </div>   
    </div>
    <br>
    <div class="m-5 mt-0 p-3">
        <h1>All Exams</h1>
        <!-- Button trigger add exam modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addExamModal">  
            Add Exam
        </button>
        <br>
        <br>
        <div id="examsContainer">

        </div>
    </div>

    {{-- Add exam modal --}}
    <div class="modal fade" id="addExamModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addExamModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div id="alertdivinner" class="mx-1 mt-1 px-1" style="height: 20px">
                    <div id="alertmessageinner" style="display: none">
            
                    </div>   
                </div>
                <form method="POST" id="addExamForm">
                    @csrf
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="addExamModalLabel">Add Exam</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input class="w-100" type="text" id="examName" name="examName" placeholder="Enter Exam Name" required>
                        <br>
                        <br>
                        <select class="w-100" name="subjectSelect" id="subjectSelect">
                            <option value="">Select Subject</option>
                            @if (count($subjects)>0)
                                @foreach ($subjects as $subject)
                                    <option value="{{ $subject->id }}">{{ $subject->subjectName }}</option>
                                @endforeach
                            @endif
                        </select>
                        <br>
                        <br>
                        <input class="w-100" type="date" id="examDate" name="examDate" required min=@php echo date('Y-m-d') @endphp>
                        <br>
                        <br>
                        <input class="w-100" type="time" id="examTime" name="examTime" required>
                        <br>
                        <br>
                        <input class="w-100" min="1" type="number" id="addExamAttempt" name="examAttempt" placeholder="Enter no of attempts possible" required>
                        <br>
                        <br>
                        <select name="plan" id="" required class="w-100 mb-4 plan">
                            <option value="">Select Plan</option>
                            <option value="0">Free</option>
                            <option value="1">Paid</option>
                        </select>
                        <input class="price" type="number" placeholder="In INR" name="inr" id="" disabled>
                        <input class="price" type="number" placeholder="In USD" name="usd" id="" disabled>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Update exam modal --}}
    <div class="modal fade" id="updateExamModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="updateExamModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div id="alertdivinnerupdate" class="mx-1 mt-1 px-1" style="height: 20px">
                    <div id="alertmessageinnerupdate" style="display: none">
            
                    </div>   
                </div>
                <form method="POST" id="updateExamForm">
                    @csrf
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="updateExamModalLabel">Update Exam</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="edit_exam_id">
                        <input class="w-100" id="edit_examName" type="text" name="examName" placeholder="Enter Exam Name" required>
                        <br>
                        <br>
                        <select class="w-100" name="subjectSelect" id="edit_subjectSelect">
                            <option value="">Select Subject</option>
                            @if (count($subjects)>0)
                                @foreach ($subjects as $subject)
                                    <option value="{{ $subject->id }}">{{ $subject->subjectName }}</option>
                                @endforeach
                            @endif
                        </select>
                        <br>
                        <br>
                        <input class="w-100" type="date" id="edit_examDate" name="examDate" required min=@php echo date('Y-m-d') @endphp>
                        <br>
                        <br>
                        <input class="w-100" type="time" id="edit_examTime" name="examTime" required>
                        <br>
                        <br>
                        <input class="w-100" min="1" type="number" id="editExamAttempt" name="examAttempt" placeholder="Enter no of attempts possible" required>
                        <br>
                        <br>
                        <select name="plan" id="updt_plan" required class="w-100 mb-4 plan">
                            <option value="">Select Plan</option>
                            <option value="0">Free</option>
                            <option value="1">Paid</option>
                        </select>
                        <input class="price" type="number" placeholder="In INR" name="inr" id="inr" disabled>
                        <input class="price" type="number" placeholder="In USD" name="usd" id="usd" disabled>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    {{-- Delete exam modal --}}
    <div class="modal fade" id="deleteExamModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteExamModallLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div id="alertdivinnerdelete" class="mx-1 mt-1 px-1" style="height: 20px">
                    <div id="alertmessageinnerdelete" style="display: none">
            
                    </div>   
                </div>
                <form method="POST" id="deleteExamForm">
                    @csrf
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="deleteExamModalLabel">Delete Exam</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete the exam?</p>
                        <input type="hidden" name="id" id="delete_exam_id">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Ok</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    {{-- Add Questions in exam modal --}}
    <div class="modal fade" id="addQuestionInExamModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addQuestionInExamModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div id="alertdivinneraddQuestion" class="mx-1 mt-1 px-1" style="height: 20px">
                    <div id="alertmessageinneraddQuestion" style="display: none">
            
                    </div>   
                </div>
                <form method="POST" id="addQuestionInExamForm">
                    @csrf
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="addQuestionInExamModalLabel">Add Questions</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="exam_id" id="exam_id">
                        <input type="text" name="search" id="search" class="w-100" onkeyup="searchTable()" placeholder="Search Questions">
                        <br>
                        <br>
                        <div id="questionsContainer">

                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Ok</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    {{-- Show Questions in exam modal --}}
    <div class="modal fade" id="showQuestionInExamModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="showQuestionInExamModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div id="alertdivinnershowQuestion" class="mx-1 mt-1 px-1" style="height: 20px">
                    <div id="alertmessageinnershowQuestion" style="display: none">
            
                    </div>   
                </div>     
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="showQuestionInExamModalLabel">Show Questions</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="show_exam_id" id="show_exam_id">
                        <div id="showquestionsContainer">

                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
            </div>
        </div>
    </div>

</div>

<script>
    $(document).ready(function(){

        // Load all exams in a table
        function loadData() {
            var idNum=1;
            $.ajax({
                url:"{{ route('admin.listExams') }}",
                type:"GET",
                success:function(data){
                    if(data.status==true){
                        var allExams = data.data;
                
                        var tabledata = `<table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Exam Name</th>
                                    <th scope="col">Subject</th>
                                    <th scope="col">Date(y-m-d)</th>
                                    <th scope="col">Time</th>
                                    <th scope="col">Attempts</th>
                                    <th scope="col">Plan</th>
                                    <th scope="col">Prices</th>
                                    <th scope="col">Add Questions</th>
                                    <th scope="col">Show Questions</th>
                                    <th scope="col">Update</th>
                                    <th scope="col">Delete</th>
                                </tr>
                            </thead>
                            <tbody>`;

                            if(allExams.length>0){
                                allExams.forEach(exam => {


                                var plan = "<span style='color:green'>FREE</span>";
                                if(exam.plan == 1){
                                    plan = "<span style='color:red'>PAID</span>";
                                }

                                var prices = "<h6 style='font-size:13px;'>NA</h6>";
                                if(exam.prices != null){
                                    var planPrices = JSON.parse(exam.prices);
                                    prices = "";
                                    for(var key in planPrices){
                                        prices += `<h6 style='font-size:13px;'>${key} ${planPrices[key]}</h6>`;

                                    }
                                }

                                tabledata += `<tr>
                                    <td><h6>${idNum++}</h6></td>
                                    <td><h6>${exam.examName}</h6></td>
                                    <td><h6>${exam.subject.subjectName}</h6></td>
                                    <td><h6>${exam.date}</h6></td>
                                    <td><h6>${exam.time} Hrs</h6></td>
                                    <td><h6>${exam.no_of_attempts_possible}</h6></td>
                                    <td><h6 style='font-size:13px;'>${plan}</h6></td>
                                    <td>${prices}</td>
                                    
                                    <td><a href="#" data-bs-examid="${exam.id}" data-bs-toggle="modal" data-bs-target="#addQuestionInExamModal">Add Questions</a></td>
                                    <td><a href="#" data-bs-examid="${exam.id}" data-bs-toggle="modal" data-bs-target="#showQuestionInExamModal">Show Questions</a></td>
                                    <td><button class="btn btn-success" data-bs-examid="${exam.id}" data-bs-toggle="modal" data-bs-target="#updateExamModal">Update</button></td>
                                    <td><button class="btn btn-danger" data-bs-examid="${exam.id}" data-bs-examname="${exam.examName}" data-bs-toggle="modal" data-bs-target="#deleteExamModal">Delete</button></td>                               
                                </tr>`;
                            });
                            } 
                            else{
                                tabledata += `<tr>
                                    <td colspan="8"><h3 class="text-center">No Exam Added</h3></td>
                                 </tr>`;
                            }

                        tabledata += `</tbody>
                                    </table>`;

                        $('#examsContainer').html(tabledata);
                    }
                }
            })
        }
        loadData();

         // Close add exam modal - Remove text in exam input
        const addExamModal = $('#addExamModal');
        if (addExamModal) {
            $('#addExamModal').on( "hide.bs.modal", function() {
                $('#examName').val("");
                $('#subjectSelect').val("");
                $('#examDate').val("");
                $('#examTime').val("");
                $('#addExamAttempt').val("");
                $('.plan').val("");
                $('.price').val("");
            } );
        }

        // Add exam to database
        $('#addExamForm').submit(function(e){
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url:"{{ route('admin.addExam') }}",
                type:"POST",
                data:formData,
                success:function(data){
                    var type="";
                    if(data.status==true){
                        $('#addExamForm').trigger("reset");
                        $('#addExamModal').modal('toggle');
                        loadData();
                        type="alert-success";
                        var elem = `<div class="alert ${type} mb-0" role="alert">${data.message}</div>`;
                        $('#alertmessage').html(elem).fadeIn('slow');
                        setTimeout(() => {
                            $('#alertmessage').fadeOut('slow');
                        }, 2000);
                    }
                    else{
                        type="alert-danger";
                        var elem = `<div class="alert ${type} mb-0" role="alert" style="padding:3px 10px;">${data.message}</div>`;
                        $('#alertmessageinner').html(elem).fadeIn('slow');
                        setTimeout(() => {
                            $('#alertmessageinner').fadeOut('slow');
                        }, 2000);
                    }
                }
            })
        })


        // Show update exam modal - Populate input fields with old data
        const updateExamModal = $('#updateExamModal');
        if (updateExamModal) {
            $('#updateExamModal').on( "show.bs.modal",updateExamModal, function(event) {
                // Button that triggered the modal
                const button = event.relatedTarget;

                // Extract info from data-bs-* attributes
                const id = button.getAttribute('data-bs-examid');
                // var url = "{{ route('admin.updateExamModal','id') }}";
                // url = url.replace('id',id);
                
                $('#inr').val("");
                $('#usd').val("");
                $.ajax({
                    url:"{{ route('admin.updateExamModal') }}",
                    type:"GET",
                    data:{'id':id},
                    success:function(data){
                        if(data.status==true){
                            $('#edit_exam_id').val(data.data.id);
                            $('#edit_examName').val(data.data.examName);
                            $('#edit_subjectSelect').val(data.data.subject_id);
                            $('#edit_examDate').val(data.data.date);
                            $('#edit_examTime').val(data.data.time);
                            $('#editExamAttempt').val(data.data.no_of_attempts_possible);
                            $('#updt_plan').val(data.data.plan);
                            
                            if(data.data.plan == 1){
                                $('#inr').attr('required','required');
                                $('#usd').attr('required','required');
                                $('#inr').prop('disabled',false);
                                $('#usd').prop('disabled',false);
                                var plan_prices = JSON.parse(data.data.prices);
                                $('#inr').val(plan_prices.INR);
                                $('#usd').val(plan_prices.USD);
                            }
                            else{
                                $('#inr').removeAttr('required','required');
                                $('#usd').removeAttr('required','required');
                                $('#inr').prop('disabled',true);
                                $('#usd').prop('disabled',true);
                                $('#inr').val("");
                                $('#usd').val("");
                            }
                        }
                        else{
                            type="alert-danger";
                            var elem = `<div class="alert ${type} mb-0" role="alert" style="padding:3px 10px;">${data.message}</div>`;
                            $('#alertmessageinnerupdate').html(elem).fadeIn('slow');
                            setTimeout(() => {
                                $('#alertmessageinnerupdate').fadeOut('slow');
                            }, 2000);
                        }
                    }
                })

            } );
        }
        

        // Update exam to database
        $('#updateExamForm').submit(function(e){
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url:"{{ route('admin.updateExam') }}",
                type:"POST",
                data:formData,
                success:function(data){
                    var type="";
                    if(data.status==true){
                        $('#updateExamForm').trigger("reset");
                        $('#updateExamModal').modal('toggle');
                        loadData();
                        type="alert-success";
                        var elem = `<div class="alert ${type} mb-0" role="alert">${data.message}</div>`;
                        $('#alertmessage').html(elem).fadeIn('slow');
                        setTimeout(() => {
                            $('#alertmessage').fadeOut('slow');
                        }, 2000);
                    }
                    else{
                        type="alert-danger";
                        var elem = `<div class="alert ${type} mb-0" role="alert" style="padding:3px 10px;">${data.message}</div>`;
                        $('#alertmessageinnerupdate').html(elem).fadeIn('slow');
                        setTimeout(() => {
                            $('#alertmessageinnerupdate').fadeOut('slow');
                        }, 2000);
                    }
                }
            })
        })



        // Show delete exam modal - Populate input fields id
        const deleteExamModal = $('#deleteExamModal');
        if (deleteExamModal) {
            $('#deleteExamModal').on( "show.bs.modal",deleteExamModal, function(event) {
                
                // Button that triggered the modal
                const button = event.relatedTarget;
                
                // Extract info from data-bs-* attributes
                const id = button.getAttribute('data-bs-examid');
                const examName = button.getAttribute('data-bs-examname');
                
                $('.modal-body p').html(`Are you sure you want to delete the '${examName}' exam?`)
                $('#delete_exam_id').val(id);
            } );
        }



        // Delete exam from database
        $('#deleteExamForm').submit(function(e){
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url:"{{ route('admin.deleteExam') }}",
                type:"POST",
                data:formData,
                success:function(data){
                    var type="";
                    if(data.status==true){
                        $('#deleteExamForm').trigger("reset");
                        $('#deleteExamModal').modal('toggle');
                        loadData();
                        type="alert-success";
                        var elem = `<div class="alert ${type} mb-0" role="alert">${data.message}</div>`;
                        $('#alertmessage').html(elem).fadeIn('slow');
                        setTimeout(() => {
                            $('#alertmessage').fadeOut('slow');
                        }, 2000);
                    }
                    else{
                        type="alert-danger";
                        var elem = `<div class="alert ${type} mb-0" role="alert" style="padding:3px 10px;">${data.message}</div>`;
                        $('#alertmessageinnerdelete').html(elem).fadeIn('slow');
                        setTimeout(() => {
                            $('#alertmessageinnerdelete').fadeOut('slow');
                        }, 2000);
                    }
                }
            })
        })


        // Populate questions on add question button click
        const addQuestionInExamModal = $('#addQuestionInExamModal');
        if (addQuestionInExamModal) {
            $('#addQuestionInExamModal').on( "show.bs.modal",addQuestionInExamModal, function(event) {
                // Button that triggered the modal
                const button = event.relatedTarget;

                // Extract info from data-bs-* attributes
                const exam_id = button.getAttribute('data-bs-examid');
                // var url = "{{ route('admin.updateExamModal','id') }}";
                // url = url.replace('id',id);
                $('#exam_id').val(exam_id);
                $.ajax({
                    url:"{{ route('admin.getQuestions') }}",
                    type:"GET",
                    data:{'exam_id':exam_id},
                    success:function(data){
                        if(data.status==true){
                            var allQns = data.data;
                
                            var tabledataQ = `<table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Select</th>
                                        <th scope="col">Question</th>
                                    </tr>
                                </thead>
                                <tbody>`;

                                if(allQns.length>0){
                                    allQns.forEach(qn => {
                                    tabledataQ += `<tr>
                                        <td><input type="checkbox" name="question_ids[]" id="" value="${qn.id}"></td>                             
                                        <td><h6>${qn.question}</h6></td>                             
                                    </tr>`;
                                });
                                } 
                                else{
                                    tabledataQ += `<tr>
                                        <td colspan="2"><h3 class="text-center">Questions not available</h3></td>
                                    </tr>`;
                                }

                            tabledataQ += `</tbody>
                                        </table>`;

                            $('#questionsContainer').html(tabledataQ);

                        }
                        else{
                            type="alert-danger";
                            var elem = `<div class="alert ${type} mb-0" role="alert" style="padding:3px 10px;">${data.message}</div>`;
                            $('#alertmessageinneraddQuestion').html(elem).fadeIn('slow');
                            setTimeout(() => {
                                $('#alertmessageinneraddQuestion').fadeOut('slow');
                            }, 2000);
                        }
                    }
                })

            } );
        }


        // Add question exam-question-relation table
        $('#addQuestionInExamForm').submit(function(e){
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url:"{{ route('admin.addQuestions') }}",
                type:"POST",
                data:formData,
                success:function(data){
                    console.log(data);
                    var type="";
                    if(data.status==true){
                        $('#addQuestionInExamForm').trigger("reset");
                        $('#addQuestionInExamModal').modal('toggle');
                        type="alert-success";
                        var elem = `<div class="alert ${type} mb-0" role="alert">${data.message}</div>`;
                        $('#alertmessage').html(elem).fadeIn('slow');
                        setTimeout(() => {
                            $('#alertmessage').fadeOut('slow');
                        }, 2000);
                    }
                    else{
                        type="alert-danger";
                        var elem = `<div class="alert ${type} mb-0" role="alert" style="padding:3px 10px;">${data.message}</div>`;
                        $('#alertmessageinneraddQuestion').html(elem).fadeIn('slow');
                        setTimeout(() => {
                            $('#alertmessageinneraddQuestion').fadeOut('slow');
                        }, 2000);
                    }
                }
            })
        })






        // Populate questions on show question button click - show questions linked to a particular exam
        const showQuestionInExamModal = $('#showQuestionInExamModal');
        if (showQuestionInExamModal) {
            $('#showQuestionInExamModal').on( "show.bs.modal",showQuestionInExamModal, function(event) {
                // Button that triggered the modal
                const button = event.relatedTarget;

                // Extract info from data-bs-* attributes
                const show_exam_id = button.getAttribute('data-bs-examid');
                // var url = "{{ route('admin.updateExamModal','id') }}";
                // url = url.replace('id',id);
                $('#show_exam_id').val(show_exam_id);
                var idNum=1;
                
                $.ajax({
                    url:"{{ route('admin.showQuestions') }}",
                    type:"GET",
                    data:{'show_exam_id':show_exam_id},
                    success:function(data){
                        
                        if(data.status==true){
                            var allQns = data.data;
                
                            var tabledataQ = `<table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Question</th>
                                        <th scope="col">Delete</th>
                                    </tr>
                                </thead>
                                <tbody>`;

                                if(allQns.length>0){
                                    allQns.forEach(qn => {
                                    tabledataQ += `<tr>
                                        <td><h6>${idNum++}</h6></td>                                                         
                                        <td><h6>${qn.questions[0].question}</h6></td>                                                         
                                        <td><button class="btn btn-danger qn_delete" data-bs-qnid="${qn.id}">Delete</button></td>                                                        
                                    </tr>`;
                                });
                                } 
                                else{
                                    tabledataQ += `<tr>
                                        <td colspan="3"><h3 class="text-center">No Question Added</h3></td>
                                    </tr>`;
                                }

                            tabledataQ += `</tbody>
                                        </table>`;

                            $('#showquestionsContainer').html(tabledataQ);

                        }
                        else{
                            type="alert-danger";
                            var elem = `<div class="alert ${type} mb-0" role="alert" style="padding:3px 10px;">${data.message}</div>`;
                            $('#alertmessageinnershowQuestion').html(elem).fadeIn('slow');
                            setTimeout(() => {
                                $('#alertmessageinnershowQuestion').fadeOut('slow');
                            }, 2000);
                        }
                    }
                })

            } );
        }


        // delete question from exam-question linked table
        $('#showQuestionInExamModal').on('click','.qn_delete',function(){
            var row = $(this);
            var id = $(this).data('bs-qnid');
            $.ajax({
                url:"{{ route('admin.deleteQuestion') }}",
                type:"GET",
                data:{'id':id},
                success:function(data){
                    var type="";
                    if(data.status==true){
                        row.parent().parent().remove();
                    }
                    else{
                        type="alert-danger";
                        var elem = `<div class="alert ${type} mb-0" role="alert" style="padding:3px 10px;">${data.message}</div>`;
                        $('#alertmessageinnershowQuestion').html(elem).fadeIn('slow');
                        setTimeout(() => {
                            $('#alertmessageinnershowQuestion').fadeOut('slow');
                        }, 2000);
                    }
                }
            })
        })




    });


</script>

<script>

    function searchTable(){
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById('search');
        filter = input.value.toLowerCase();
        table = document.querySelector('#questionsContainer table tbody');
        tr = table.getElementsByTagName("tr");
        // console.log(tr);
        for(i=0; i<tr.length; i++){
            td = tr[i].getElementsByTagName("td")[1];
            if(td){
                txtValue = td.textContent || td.innerText;
                if(txtValue.toLowerCase().indexOf(filter)>-1){
                    tr[i].style.display = "";
                }
                else{
                    tr[i].style.display = "none";
                }
            }
        }
    }



    // Plan JS
    $('.plan').change(function(){
        var plan = $(this).val();
        if(plan==1){
            $(this).next().attr('required','required');
            $(this).next().next().attr('required','required');
            $(this).next().prop('disabled',false);
            $(this).next().next().prop('disabled',false);
        }
        else{
            $(this).next().removeAttr('required','required');
            $(this).next().next().removeAttr('required','required');
            $(this).next().prop('disabled',true);
            $(this).next().next().prop('disabled',true);
            $(this).next().val("");
            $(this).next().next().val("");
        }
    })

</script>



@endsection