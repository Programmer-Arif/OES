@extends('admin.layout.admin-dashboard-layout')

@section('work-space')

<div>
    <div id="alertdiv" class="mx-5 mt-2 px-3" style="height: 30px">
        <div id="alertmessage" style="display: none">

        </div>   
    </div>
    <br>
    <div class="m-5 mt-0 p-3">
        <h1>All Q&A</h1>
        <!-- Button trigger add qna modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addQNAModal">  
            Add Q&A
        </button>
        <!-- Button trigger add excel file modal -->
        <button type="button" class="btn btn-info ms-3" data-bs-toggle="modal" data-bs-target="#importQNAModal">  
            Import Q&A
        </button>
        <br>
        <br>
        <div id="qnasContainer">

        </div>
    </div>

    {{-- Add qna modal --}}
    <div class="modal fade" id="addQNAModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addQNAModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div id="alertdivinner" class="mx-1 mt-1 px-1" style="height: 20px">
                    <div id="alertmessageinner" style="display: none">
            
                    </div>   
                </div>
                <form method="POST" id="addQNAForm">
                    @csrf
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="addQNAModalLabel">Add Q&A</h1>

                        <button type="button" class="btn btn-info ms-5" id="addAnswer">Add Answer</button>

                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        
                        <div class="row">
                            <div class="col">
                                <input class="w-100" type="text" id="question" name="question" placeholder="Enter Question" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <textarea class="mt-3 w-100" rows="3" name="explaination" id="explaination" placeholder="Explaination(optional)"></textarea>
                            </div>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <span class="error" style="color:red;"></span>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    {{-- Import qna modal --}}
    <div class="modal fade" id="importQNAModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="importQNAModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div id="alertdivinnerimport" class="mx-1 mt-1 px-1" style="height: 20px">
                    <div id="alertmessageinnerimport" style="display: none">
            
                    </div>   
                </div>
                <form method="POST" id="importQNAForm" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="importQNAModalLabel">Import Q&A</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        
                        <div class="row">
                            <div class="col">
                                <input class="w-100" type="file" id="import_qna" name="import_qna" accept=".csv,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms.excel" required>
                            </div>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-info">Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    {{-- Answer modal --}}
    <div class="modal fade" id="answerModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="answerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

                
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="answerModalLabel">Show Answers</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                
            </div>
        </div>
    </div>



    {{-- Update qna modal --}}
    <div class="modal fade" id="updateQNAModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="updateQNAModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div id="alertdivinnerupdate" class="mx-1 mt-1 px-1" style="height: 20px">
                    <div id="alertmessageinnerupdate" style="display: none">
            
                    </div>   
                </div>
                <form method="POST" id="updateQNAForm">
                    @csrf
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="updateQNAModalLabel">Update QNA</h1>
                        <button type="button" class="btn btn-info ms-5" id="edit_addAnswer">Add Answer</button>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                       
                        <div class="row">
                            <div class="col">
                                <input type="hidden" name="id" id="edit_qna_id">
                                <label for="edit_question">Question: </label>
                                <input class="w-100" type="text" id="edit_question" name="question" placeholder="Enter Question" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="explaination_updt">Explaination: </label>
                                <textarea class="w-100" rows="3" name="explaination_updt" id="explaination_updt" placeholder="Explaination(optional)"></textarea>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <span class="edit_error" style="color:red;"></span>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    {{-- Delete qna modal --}}
    <div class="modal fade" id="deleteQNAModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteQNAModallLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div id="alertdivinnerdelete" class="mx-1 mt-1 px-1" style="height: 20px">
                    <div id="alertmessageinnerdelete" style="display: none">
            
                    </div>   
                </div>
                <form method="POST" id="deleteQNAForm">
                    @csrf
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="deleteQNAModalLabel">Delete QNA</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete the qna?</p>
                        <input type="hidden" name="id" id="delete_qna_id">
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

        // Load all qnas in a table
        function loadData() {
            var idNum=1;
            $.ajax({
                url:"{{ route('admin.listQNAs') }}",
                type:"GET",
                success:function(data){
                    if(data.status==true){
                        var allQNAs = data.data;
                       
                
                        var tabledata = `<table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Question</th>
                                    <th scope="col">Answer</th>
                                    <th scope="col">Update</th>
                                    <th scope="col">Delete</th>
                                </tr>
                            </thead>
                            <tbody>`;

                            if(allQNAs.length>0){
                                allQNAs.forEach(qna => {
                                tabledata += `<tr>
                                    <td><h6>${idNum++}</h6></td>
                                    <td><h6>${qna.question}</h6></td>
                                    <td><a href="#" class="ansButton" data-bs-ansid="${qna.id}" data-bs-toggle="modal" data-bs-target="#answerModal">See Answers</a></td>
                                    <td><button class="btn btn-success" data-bs-qnaid="${qna.id}" data-bs-toggle="modal" data-bs-target="#updateQNAModal">Update</button></td>
                                    <td><button class="btn btn-danger" data-bs-qnaid="${qna.id}" data-bs-toggle="modal" data-bs-target="#deleteQNAModal">Delete</button></td>
                                </tr>`;
                            });
                            } 
                            else{
                                tabledata += `<tr>
                                    <td colspan="5"><h3 class="text-center">No QNA Added</h3></td>
                                 </tr>`;
                            }

                        tabledata += `</tbody>
                                    </table>`;

                        $('#qnasContainer').html(tabledata);
                    }
                }
            })
        }
        loadData();

        // Show Answer modal on click of see answers - view answers in a table in the modal
        const answerModal = $('#answerModal');
        if (answerModal) {
            $('#answerModal').on( "show.bs.modal",answerModal, function(event) {
                // Button that triggered the modal
                const button = event.relatedTarget;

                // Extract info from data-bs-* attributes
                const id = button.getAttribute('data-bs-ansid');

                $.ajax({
                    url:"{{ route('admin.showAnsModal') }}",
                    type:"GET",
                    data:{'id':id},
                    success:function(data){
                        if(data.status==true){
                            var idNum=1;
                            var allans = data.data;
                       
                            var tabledata = `<table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Answers</th>
                                        <th scope="col">Is Correct</th>
                                    </tr>
                                </thead>
                                <tbody>`;

                                if(allans.length>0){
                                    allans.forEach(ans => {
                                        
                                    var flag="False";
                                    if(ans.is_correct==true){
                                        flag="True";
                                    }
                                    tabledata += `<tr>
                                        <td><h6>${idNum++}</h6></td>
                                        <td><h6>${ans.answer}</h6></td>
                                        <td><h6>${flag}</h6></td>
                                    </tr>`;

                                });
                                } 
                                else{
                                    tabledata += `<tr>
                                        <td colspan="3"><h3 class="text-center">No QNA Added</h3></td>
                                    </tr>`;
                                }

                            tabledata += `</tbody>
                                        </table>`;

                            $('#answerModal .modal-body').html(tabledata);
                        }
                    }
                })


            } );
        }



        // Close add qna modal - Remove text in qna input
        const addQNAModal = $('#addQNAModal');
        if (addQNAModal) {
            $('#addQNAModal').on( "hide.bs.modal", function() {
                var ohtml = `<div class="row">
                            <div class="col">
                                <input class="w-100" type="text" id="question" name="question" placeholder="Enter Question" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <textarea class="mt-3 w-100" rows="3" name="explaination" id="explaination" placeholder="Explaination(optional)"></textarea>
                            </div>
                        </div>`;

                $('#addQNAModal .modal-body').html(ohtml);     

            } );
        }


        // on click of add answer button
        $('#addAnswer').click(function(){
            if($('.answers').length >= 6){
                $('.error').text('You can add maximum of six answers');
                setTimeout(function(){
                    $('.error').text('');
                },2000);
            }else{
                var html = `<div class="row answers mt-3">
                            <div class="col">
                                <input type="radio" name="is_correct" class="is_correct">
                                <input class="w-75" type="text" name="answers[]" placeholder="Enter Answer" required>
                                <button class="btn btn-danger removeButton">Remove</button>
                            </div>
                        </div>`;

                $('#addQNAModal .modal-body').append(html);
            }

        })

        // on click of remove button of answer option
        $('#addQNAModal').on('click','.removeButton',function(){
            $(this).parent().parent().remove();
        })
        

        // Add qna to database
        $('#addQNAForm').submit(function(e){
            e.preventDefault();

            if($('.answers').length < 2){
                $('.error').text('Please add minimum two answers');
                setTimeout(function(){
                    $('.error').text('');
                },2000);
            }else{

                var radioCheck = false;
                for (let i = 0; i < $('.is_correct').length; i++) {
                   if( $(`.is_correct:eq(${i})`).prop('checked') == true ){
                        radioCheck = true;
                        $(`.is_correct:eq(${i})`).val($(`.is_correct:eq(${i})`).next().val());
                   }
                    
                }

                if(radioCheck){
                    var formData = $(this).serialize();
                    $.ajax({
                        url:"{{ route('admin.addQNA') }}",
                        type:"POST",
                        data:formData,
                        success:function(data){
                           
                            var type="";
                            if(data.status==true){
                                $('#addQNAForm').trigger("reset");
                                $('#addQNAModal').modal('toggle');
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
                }else{
                    $('.error').text('Please select any answer');
                    setTimeout(function(){
                        $('.error').text('');
                    },2000);
                }
            }
                
        })


         // Import qna to database
         $('#importQNAForm').submit(function(e){
            e.preventDefault();

            let formData = new FormData();
            formData.append('import_qna',import_qna.files[0]) 
            
            $.ajaxSetup({
                headers:{
                    "X-CSRF-TOKEN":"{{ csrf_token() }}"
                }
            });

            $.ajax({
                url:"{{ route('admin.importQNA') }}",
                type:"POST",
                data:formData,
                processData:false,
                contentType:false,
                success:function(data){
                    var type="";
                    if(data.status==true){
                        $('#importQNAForm').trigger("reset");
                        $('#importQNAModal').modal('toggle');
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
                        $('#alertmessageinnerimport').html(elem).fadeIn('slow');
                        setTimeout(() => {
                            $('#alertmessageinnerimport').fadeOut('slow');
                        }, 2000);
                    }
                }
            })
                
        })


        // Close update qna modal - Remove text in qna input
        const clsUpdateQNAModal = $('#updateQNAModal');
        if (clsUpdateQNAModal) {
            $('#updateQNAModal').on( "hide.bs.modal", function() {
                var uohtml = `<div class="row">
                            <div class="col">
                                <input type="hidden" name="id" id="edit_qna_id">
                                <label for="edit_question">Question: </label>
                                <input class="w-100" type="text" id="edit_question" name="question" placeholder="Enter Question" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="explaination_updt">Explaination: </label>
                                <textarea class="w-100" rows="3" name="explaination_updt" id="explaination_updt" placeholder="Explaination(optional)"></textarea>
                            </div>
                        </div>`;

                $('#updateQNAModal .modal-body').html(uohtml);     

            } );
        }

        // on click of add answer button (edit section)
        $('#edit_addAnswer').click(function(){
            if($('.edit_answers').length >= 6){
                $('.edit_error').text('You can add maximum of six answers');
                setTimeout(function(){
                    $('.edit_error').text('');
                },2000);
            }else{
                var uhtml = `<div class="row edit_answers mt-3">
                            <div class="col">
                                <input type="radio" name="is_correct" class="edit_is_correct">
                                <input class="w-75" type="text" name="new_answers[]" placeholder="Enter Answer" required>
                                <button class="btn btn-danger removeButton">Remove</button>
                            </div>
                        </div>`;

                $('#updateQNAModal .modal-body').append(uhtml);
            }

        })

        // on click of remove button of answer option (in edit) [NEW]
        $('#updateQNAModal').on('click','.removeButton',function(){
            $(this).parent().parent().remove();
        })

        // on click of remove button of answer option (in edit) [OLD]
        $('#updateQNAModal').on('click','.removeAnswer',function(){
            var ansId = $(this).attr('data-id');
            $.ajax({
                url:"{{ route('admin.removeAns') }}",
                type:"GET",
                data:{id:ansId},
                success:function(data){
                    if(data.status==true){
                            
                            console.log(data.message);
                            
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
            });
        })


        
        // Show update qna modal - Populate input fields with old data
        const updateQNAModal = $('#updateQNAModal');
        if (updateQNAModal) {
            $('#updateQNAModal').on( "show.bs.modal",updateQNAModal, function(event) {
                // Button that triggered the modal
                const button = event.relatedTarget;

                // Extract info from data-bs-* attributes
                const id = button.getAttribute('data-bs-qnaid');

                $.ajax({
                    url:"{{ route('admin.updateQNAModal') }}",
                    type:"GET",
                    data:{'id':id},
                    success:function(data){
                        if(data.status==true){
                            
                            $('#edit_qna_id').val(data.data.id);
                            $('#edit_question').val(data.data.question);
                            $('#explaination_updt').val(data.data.explaination);

                            var html="";
                            data.data.answers.forEach(function(val){

                                var checked="";
                                if(val.is_correct==true){
                                    checked="checked";
                                }

                                html += `<div class="row edit_answers mt-3">
                                        <div class="col">
                                            <input ${checked} type="radio" name="is_correct" class="edit_is_correct">
                                            <input value="${val.answer}" class="w-75" type="text" name="answers[${val.id}]" placeholder="Enter Answer" required>
                                            <button class="btn btn-danger removeButton removeAnswer" data-id="${val.id}">Remove</button>
                                        </div>
                                    </div>`;
                            })

                            $('#updateQNAModal .modal-body').append(html);
                            
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
        

        // Update qna to database
        $('#updateQNAForm').submit(function(e){
            e.preventDefault();


            if($('.edit_answers').length < 2){
                $('.edit_error').text('Please add minimum two answers');
                setTimeout(function(){
                    $('.edit_error').text('');
                },2000);
            }else{

                var new_radioCheck = false;
                for (let i = 0; i < $('.edit_is_correct').length; i++) {
                   if( $(`.edit_is_correct:eq(${i})`).prop('checked') == true ){
                        new_radioCheck = true;
                        $(`.edit_is_correct:eq(${i})`).val($(`.edit_is_correct:eq(${i})`).next().val());
                   }
                    
                }

                if(new_radioCheck){
                    var formData = $(this).serialize();
                    $.ajax({
                        url:"{{ route('admin.updateQNA') }}",
                        type:"POST",
                        data:formData,
                        success:function(data){
                            console.log(data);
                            var type="";
                            if(data.status==true){
                                $('#updateQNAForm').trigger("reset");
                                $('#updateQNAModal').modal('toggle');
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
                }else{
                    $('.edit_error').text('Please select any answer');
                    setTimeout(function(){
                        $('.edit_error').text('');
                    },2000);
                }
            }



            
            
        })



        // Show delete qna modal - Populate input fields id
        const deleteQNAModal = $('#deleteQNAModal');
        if (deleteQNAModal) {
            $('#deleteQNAModal').on( "show.bs.modal",deleteQNAModal, function(event) {
                
                // Button that triggered the modal
                const button = event.relatedTarget;
                
                // Extract info from data-bs-* attributes
                const id = button.getAttribute('data-bs-qnaid');

                $('#delete_qna_id').val(id);
            } );
        }



        // Delete qna from database
        $('#deleteQNAForm').submit(function(e){
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url:"{{ route('admin.deleteQNA') }}",
                type:"POST",
                data:formData,
                success:function(data){
                    var type="";
                    if(data.status==true){
                        $('#deleteQNAForm').trigger("reset");
                        $('#deleteQNAModal').modal('toggle');
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