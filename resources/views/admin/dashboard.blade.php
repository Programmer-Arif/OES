@extends('admin.layout.admin-dashboard-layout')

@section('work-space')

<div>
    <div id="alertdiv" class="mx-5 mt-2 px-3" style="height: 30px">
        <div id="alertmessage" style="display: none">

        </div>   
    </div>
    <br>
    <div class="m-5 mt-0 p-3">
        <h1>All Subjects</h1>
        <!-- Button trigger add subject modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSubjectModal">  
            Add Subject
        </button>
        <br>
        <br>
        <div id="subjectsContainer">

        </div>
    </div>

    {{-- Add subject modal --}}
    <div class="modal fade" id="addSubjectModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addSubjectModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div id="alertdivinner" class="mx-1 mt-1 px-1" style="height: 20px">
                    <div id="alertmessageinner" style="display: none">
            
                    </div>   
                </div>
                <form method="POST" id="addSubjectForm">
                    @csrf
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="addSubjectModalLabel">Add Subject</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        {{-- <label for="addSubjectInput">Subject: </label> --}}
                        <input class="w-100" type="text" id="addSubjectInput" name="subjectName" placeholder="Enter Subject Name" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Update subject modal --}}
    <div class="modal fade" id="updateSubjectModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="updateSubjectModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div id="alertdivinnerupdate" class="mx-1 mt-1 px-1" style="height: 20px">
                    <div id="alertmessageinnerupdate" style="display: none">
            
                    </div>   
                </div>
                <form method="POST" id="updateSubjectForm">
                    @csrf
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="updateSubjectModalLabel">Update Subject</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <label for="updateSubjectInput">Subject: </label>
                        <input type="hidden" name="id" id="edit_subject_id">
                        <input type="text" id="updateSubjectInput" name="subjectName" placeholder="Enter Subject Name" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    {{-- Delete subject modal --}}
    <div class="modal fade" id="deleteSubjectModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteSubjectModallLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div id="alertdivinnerdelete" class="mx-1 mt-1 px-1" style="height: 20px">
                    <div id="alertmessageinnerdelete" style="display: none">
            
                    </div>   
                </div>
                <form method="POST" id="deleteSubjectForm">
                    @csrf
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="deleteSubjectModalLabel">Delete Subject</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete the subject?</p>
                        <input type="hidden" name="id" id="delete_subject_id">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Ok</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<script>
    $(document).ready(function(){

        // Load all subjects in a table
        function loadData() {
            var idNum=1;
            $.ajax({
                url:"{{ route('admin.listSubjects') }}",
                type:"GET",
                success:function(data){
                    if(data.status==true){
                        var allSubjects = data.data;
                        
                        var tabledata = `<table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Subject Name</th>
                                    <th scope="col">Update</th>
                                    <th scope="col">Delete</th>
                                </tr>
                            </thead>
                            <tbody>`;
                            if(allSubjects.length>0){
                                allSubjects.forEach(subject => {
                                    tabledata += `<tr>
                                        <td><h6>${idNum++}</h6></td>
                                        <td><h6>${subject.subjectName}</h6></td>
                                        <td><button class="btn btn-success" data-bs-subjectid="${subject.id}" data-bs-subjectname="${subject.subjectName}" data-bs-toggle="modal" data-bs-target="#updateSubjectModal">Update</button></td>
                                        <td><button class="btn btn-danger" data-bs-subjectid="${subject.id}" data-bs-subjectname="${subject.subjectName}" data-bs-toggle="modal" data-bs-target="#deleteSubjectModal">Delete</button></td>                               
                                    </tr>`;
                                });
                            } 
                            else{
                                tabledata += `<tr>
                                    <td colspan="4"><h3 class="text-center">No Subject Added</h3></td>
                                 </tr>`;
                            }
                          
                              
                        tabledata += `</tbody>
                                    </table>`;

                        $('#subjectsContainer').html(tabledata);
                    }
                }
            })
        }
        loadData();

         // Close add subject modal - Remove text in subject input
        const addSubjectModal = $('#addSubjectModal');
        if (addSubjectModal) {
            $(addSubjectModal).on( "hide.bs.modal", function() {
                $('#addSubjectInput').val("");
            } );
        }

        // Add subject to database
        $('#addSubjectForm').submit(function(e){
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url:"{{ route('admin.addSubject') }}",
                type:"POST",
                data:formData,
                success:function(data){
                    var type="";
                    if(data.status==true){
                        $('#addSubjectForm').trigger("reset");
                        $('#addSubjectModal').modal('toggle');
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


        // Show update subject modal - Populate input fields with old data
        const updateSubjectModal = $('#updateSubjectModal');
        if (updateSubjectModal) {
            $('#updateSubjectModal').on( "show.bs.modal",updateSubjectModal, function(event) {

                // Button that triggered the modal
                const button = event.relatedTarget;

                // Extract info from data-bs-* attributes
                const id = button.getAttribute('data-bs-subjectid');
                const subjectName = button.getAttribute('data-bs-subjectname');

                $('#edit_subject_id').val(id);
                $('#updateSubjectInput').val(subjectName);
            } );
        }


        
        

        // Update subject to database
        $('#updateSubjectForm').submit(function(e){
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url:"{{ route('admin.updateSubject') }}",
                type:"POST",
                data:formData,
                success:function(data){
                    var type="";
                    if(data.status==true){
                        $('#updateSubjectForm').trigger("reset");
                        $('#updateSubjectModal').modal('toggle');
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



        // Show delete subject modal - Populate input fields id
        const deleteSubjectModal = $('#deleteSubjectModal');
        if (deleteSubjectModal) {
            $('#deleteSubjectModal').on( "show.bs.modal",deleteSubjectModal, function(event) {
                
                // Button that triggered the modal
                const button = event.relatedTarget;
                
                // Extract info from data-bs-* attributes
                const id = button.getAttribute('data-bs-subjectid');
                const subjectName = button.getAttribute('data-bs-subjectname');
                
                $('.modal-body p').html(`Are you sure you want to delete the '${subjectName}' subject?`)
                $('#delete_subject_id').val(id);
            } );
        }



        // Delete subject from database
        $('#deleteSubjectForm').submit(function(e){
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url:"{{ route('admin.deleteSubject') }}",
                type:"POST",
                data:formData,
                success:function(data){
                    var type="";
                    if(data.status==true){
                        $('#deleteSubjectForm').trigger("reset");
                        $('#deleteSubjectModal').modal('toggle');
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




    });


</script>



@endsection