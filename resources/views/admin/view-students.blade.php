@extends('admin.layout.admin-dashboard-layout')

@section('work-space')

<div>
    <div id="alertdiv" class="mx-5 mt-2 px-3" style="height: 30px">
        <div id="alertmessage" style="display: none">

        </div>   
    </div>
    <br>
    <div class="m-5 mt-0 p-3">
        <h1>All Students</h1>
        <br>
        <a href="{{ route('admin.exportStudents') }}" class="btn btn-warning">Export Students</a>


        <br>
        <br>
        <div id="studentsContainer">

        </div>
    </div>
    
</div>

<script>
    $(document).ready(function(){

        // Load all students in a table
        function loadData() {
            var idNum=1;
            $.ajax({
                url:"{{ route('admin.listStudents') }}",
                type:"GET",
                success:function(data){
                    if(data.status==true){
                        var allStudents = data.data;
                
                        var tabledata = `<table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                </tr>
                            </thead>
                            <tbody>`;

                            if(allStudents.length>0){
                                allStudents.forEach(student => {
                                tabledata += `<tr>
                                    <td><h6>${idNum++}</h6></td>
                                    <td><h6>${student.name}</h6></td>
                                    <td><h6>${student.email}</h6></td>                               
                                </tr>`;
                            });
                            } 
                            else{
                                tabledata += `<tr>
                                    <td colspan="3"><h3 class="text-center">No Student Added</h3></td>
                                 </tr>`;
                            }

                        tabledata += `</tbody>
                                    </table>`;

                        $('#studentsContainer').html(tabledata);
                    }
                }
            })
        }
        loadData();
        



    });


</script>



@endsection