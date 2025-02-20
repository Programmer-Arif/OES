@extends('admin.layout.admin-dashboard-layout')

@section('work-space')

<div>
    <div id="alertdiv" class="mx-5 mt-2 px-3" style="height: 30px">
        <div id="alertmessage" style="display: none">

        </div>   
    </div>
    <br>
    <div class="m-5 mt-0 p-3">
        <h1>Marks</h1>
    
        <div id="examsMarksContainer">

        </div>
    </div>


    {{-- Update exam marks modal --}}
    <div class="modal fade" id="updateMarksModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="updateMarksModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div id="alertdivinnerupdate" class="mx-1 mt-1 px-1" style="height: 20px">
                    <div id="alertmessageinnerupdate" style="display: none">
            
                    </div>   
                </div>
                <form method="POST" id="updateExamMarksForm">
                    @csrf
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="updateMarksModalLabel">Update Marks</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="edit_exam_id">
                        <label for="marks_per_q">Marks Per Question : </label>
                        <input type="text" onkeypress=" return event.charCode>=48 && event.charCode<=57 || event.charCode==46" name="marks_per_q" id="marks_per_q" >
                        <br>
                        <br>
                        <label for="Tmarks">Total Marks : </label>
                        <input type="text" name="" id="Tmarks" disabled>
                        <br>
                        <br>
                        <label for="Pmarks">Passing Marks : </label>
                        <input type="text" id="Pmarks" name="Pmarks" onkeypress=" return event.charCode>=48 && event.charCode<=57 || event.charCode==46">
                        <div style="height: 30px">
                            <div id="passError" style="display: none;">
                
                            </div>  
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<script>
    
    $(document).ready(function(){

        let totalQ = 0;
        // Load all exams in a table
        function loadData() {
            var idNum=1;
            $.ajax({
                url:"{{ route('admin.listMarks') }}",
                type:"GET",
                success:function(data){
                    if(data.status==true){
                        var allExams = data.data;
                        console.log(allExams);
                
                        var tabledata = `<table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Exam Name</th>
                                    <th scope="col">Marks/Q</th>
                                    <th scope="col">Number of Q</th>
                                    <th scope="col">Total Marks</th>
                                    <th scope="col">Passing Marks</th>
                                    <th scope="col">Edit</th>
                                </tr>
                            </thead>
                            <tbody>`;

                            if(allExams.length>0){
                                allExams.forEach(exam => {

                                tabledata += `<tr>
                                    <td><h6>${idNum++}</h6></td>
                                    <td><h6>${exam.examName}</h6></td>
                                    <td><h6>${exam.marks_per_q}</h6></td>
                                    <td><h6>${exam.get_qna_exam.length}</h6></td>
                                    <td><h6>${(exam.get_qna_exam.length * exam.marks_per_q).toFixed(1)}</h6></td>
                                    <td><h6>${exam.passing_marks}</h6></td>
                                    <td><button class="btn btn-success" data-bs-examid="${exam.id}" data-bs-toggle="modal" data-bs-target="#updateMarksModal">Update</button></td>                              
                                </tr>`;
                            });
                            } 
                            else{
                                tabledata += `<tr>
                                    <td colspan="6"><h3 class="text-center">No Exam Added</h3></td>
                                </tr>`;
                            }

                        tabledata += `</tbody>
                                    </table>`;

                        $('#examsMarksContainer').html(tabledata);
                    }
                }
            })
        }
        loadData();


         // Show update exam modal for marks update - Populate input fields with old data
         const updateMarksModal = $('#updateMarksModal');
        if (updateMarksModal) {
            $('#updateMarksModal').on( "show.bs.modal",updateMarksModal, function(event) {
                // Button that triggered the modal
                const button = event.relatedTarget;

                // Extract info from data-bs-* attributes
                const id = button.getAttribute('data-bs-examid');
                // var url = "{{ route('admin.updateExamModal','id') }}";
                // url = url.replace('id',id);
                $.ajax({
                    url:"{{ route('admin.updateMarksModal') }}",
                    type:"GET",
                    data:{'id':id},
                    success:function(data){
                        if(data.status==true){
                            $('#edit_exam_id').val(data.data.id);
                            $('#marks_per_q').val(data.data.marks_per_q);
                            $('#Tmarks').val((data.data.get_qna_exam.length * data.data.marks_per_q).toFixed(1));
                            $('#Pmarks').val(data.data.passing_marks);
                            totalQ = data.data.get_qna_exam.length;
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


        
        $('#marks_per_q').on('keyup',function(){
            $('#Tmarks').val((totalQ * $(this).val()).toFixed(1));
        })

        $('#Pmarks').on('keyup',function(){
            // $('#passError').remove();
            var Tmarks = $('#Tmarks').val();
            var Pmarks = $(this).val();

            if(parseFloat(Pmarks) >= parseFloat(Tmarks)){
                $('#passError').html('<p style="color:red;">Passing Marks should be less than total marks </p>').fadeIn();
                setTimeout(() => {
                    $('#passError').fadeOut('slow');
                }, 2000);
            }

        })



        // Update marks in exam table to database
        $('#updateExamMarksForm').submit(function(e){
            e.preventDefault();

            var Tmarks = $('#Tmarks').val();
            var Pmarks = $('#Pmarks').val();

            if(parseFloat(Pmarks) >= parseFloat(Tmarks)){
                $('#passError').html('<p style="color:red;">Passing Marks should be less than total marks </p>').fadeIn();
                setTimeout(() => {
                    $('#passError').fadeOut('slow');
                }, 2000);

                return false;
            }


            var formData = $(this).serialize();
            $.ajax({
                url:"{{ route('admin.updateMarks') }}",
                type:"POST",
                data:formData,
                success:function(data){
                    var type="";
                    if(data.status==true){
                        $('#updateExamMarksForm').trigger("reset");
                        $('#updateMarksModal').modal('toggle');
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

        


    });


</script>



@endsection