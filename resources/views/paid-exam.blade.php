@extends('layout.dashboard-layout')

@section('work-space')

<div>
    @if (Session::has('paypalsuccess'))
    <div class="alert alert-success" id="paypal-success-message">
        {{ Session::get('paypalsuccess') }}
    </div>

    <script>
        setTimeout(function() {
            document.getElementById('paypal-success-message').style.display = 'none';
        }, 2000);
    </script>
    @endif
    @if (Session::has('paypalfail'))
        <div class="alert alert-danger" id="paypal-fail-message">
            {{ Session::get('paypalfail') }}
        </div>

        <script>
            setTimeout(function() {
                document.getElementById('paypal-fail-message').style.display = 'none';
            }, 2000);
        </script>
    @endif
</div>

<div>
    <div class="m-5 mt-0 p-3">
        <h1>Paid Exam</h1>
        
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
                            @if (count($exam->getPaidInformation) > 0 && $exam->getPaidInformation[0]->user_id==auth()->user()->id)
                                <td><a href="#" data-code="{{ $exam->entrance_id }}" class="copy"> <i class="fa fa-copy"></i> </a></td>
                            @else
                                <td><a href="#" data-id="{{ $exam->id }}" data-name="{{ $exam->examName }}" data-prices="{{ $exam->prices }}" data-bs-toggle="modal" data-bs-target="#buyExamModal">Buy Now</a></td>
                            @endif
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

    {{-- Buy Now exam modal --}}
    <div class="modal fade" id="buyExamModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="buyExamModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div id="alertdivinnerbuy" class="mx-1 mt-1 px-1" style="height: 20px">
                    <div id="alertmessageinnerbuy" style="display: none">
            
                    </div>   
                </div>
                <form method="POST" id="buyExamForm">
                    @csrf
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="buyExamModalLabel">Buy Exam</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <select name="price" id="price" required class="w-100">
                        </select>
                        <input type="hidden" id="exam_id" name="examid">
                        <input type="hidden" id="exam_name" name="examname">

                        {{-- to be used only in paypal --}}
                        <input type="hidden" name="price_paypal" id="price_paypal">
                        <input type="hidden" name="product_name" id="product_name">
                        <input type="hidden" name="quantity" id="quantity">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-warning buyNowButton">Buy Now</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>






{{-- <form action="{{ config('paypal.payment_checkout_url') }}" method="POST" id="paypalForm">

    @csrf
    <input type="hidden" name="business" value="{{ config('paypal.business_mail') }}">
    <input type="hidden" name="cmd" value="_xclick">
    <input type="hidden" name="item_name" id="item_name">
    <input type="hidden" name="item_number" id="item_number">
    <input type="hidden" name="amount" id="amount">
    <input type="hidden" name="currency_code" value="USD">
    <input type="hidden" name="cancel_return" value="{{ route('paidExamDashboard') }}">
    <input type="hidden" name="return" id="return">


</form> --}}
{{-- <form action="" method="POST">

    @csrf
    <input type="hidden" name="price_paypal" id="price_paypal">
    <input type="hidden" name="product_name" id="product_name">
    <input type="hidden" name="quantity" id="quantity">


</form> --}}





<script>

    var isInr = false;

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



        // Show buy exam modal - Populate input fields id
        const buyExamModal = $('#buyExamModal');
        if (buyExamModal) {
            $('#buyExamModal').on( "show.bs.modal",buyExamModal, function(event) {
                
                // Button that triggered the modal
                const button = event.relatedTarget;
                
                // Extract info from data-bs-* attributes
                const prices = JSON.parse(button.getAttribute('data-prices'));
                
                var html="";
                html += `
                            <option value="">Select Currency</option>
                            <option value="${prices.INR}">INR ${prices.INR}</option>
                            <option value="${prices.USD}">USD ${prices.USD}</option>
                            
                        `;
                
                $('#price').html(html);
                
                $('#exam_id').val( $(button).attr('data-id') );
                $('#exam_name').val( $(button).attr('data-name') );


            } );
        }


        $('#price').change(function(){
            var text = $('#price option:selected').text();
            if(text.includes('INR')){
                isInr = true;
            }
            else{
                isInr = false;
            }
        });


        // buy exam from database
        $('#buyExamForm').submit(function(e){
            e.preventDefault();

            
            $('.buyNowButton').text('Please wait...');
            

            var formData = $(this).serialize();
            var price = $('#price').val();
            var exam_id = $('#exam_id').val();
            var exam_name = $('#exam_name').val();
        
            

            if(isInr == true){
                $.ajax({
                    url:"{{ route('account.paymentInr') }}",
                    type:"POST",
                    data:formData,
                    success:function(data){
                        console.log(data);
                        var type="";
                        if(data.status==true){
                            // $callback_url = "{{ route('account.paymentSuccess') }}";
                            var options = {
                                key: "{{ config('app.paymentkey') }}", 

                                currency: "INR",
                                name: "{{ auth()->user()->name }}",
                                description: "Oes Paid Exam Transaction",
                                image: "https://cdn.razorpay.com/logos/GhRQcyean79PqE_medium.png",
                                order_id: data.order_id, 
                                "handler": function (response){
                                    var paymentData = {
                                        exam_id:exam_id,
                                        razorpay_payment_id:response.razorpay_payment_id,
                                        razorpay_order_id:response.razorpay_order_id,
                                        razorpay_signature:response.razorpay_signature,
                                    }

                                    $.ajax({
                                        url:"{{ route('account.varifyPayment') }}",
                                        type:"GET",
                                        data:paymentData,
                                        success:function(response){
                                            alert(response.message);
                                            location.reload();
                                        }
                                    })
                                    
                                },
                                prefill: {
                                    name: "{{ auth()->user()->name }}",
                                    email: "{{ auth()->user()->email }}",
                                    contact: "9000090000"
                                },
                                notes: {
                                    address: "Razorpay Corporate Office {{ auth()->user()->email }}"
                                },
                                theme: {
                                    "color": "#3399cc"
                                },
                                // callback_url: $callback_url
                            };
                            var rzp = new Razorpay(options);
                            rzp.on('payment.failed', function (response){
                                alert(response.error.code);
                                alert(response.error.description);
                                alert(response.error.source);
                                alert(response.error.step);
                                alert(response.error.reason);
                                alert(response.error.metadata.order_id);
                                alert(response.error.metadata.payment_id);
                            });
                            rzp.open();


                            
                        }
                        else{
                            type="alert-danger";
                            var elem = `<div class="alert ${type} mb-0" role="alert" style="padding:3px 10px;">${data.message}</div>`;
                            $('#alertmessageinnerbuy').html(elem).fadeIn('slow');
                            setTimeout(() => {
                                $('#alertmessageinnerbuy').fadeOut('slow');
                            }, 2000);
                        }
                    }
                })
            }
            else{
                $('#price_paypal').val(price);
                $('#product_name').val(exam_name);
                $('#quantity').val('1');
                formData = $(this).serialize();
                $.ajax({
                    url:"{{ route('account.paypal') }}",
                    type:"POST",
                    data:formData,
                    success:function(data){
                        console.log(data);
                        // var type="";
                        if(data.status==true){
                            

                            window.open(data.link,'_self');
                           


                            
                        }
                        else{
                            type="alert-danger";
                            var elem = `<div class="alert ${type} mb-0" role="alert" style="padding:3px 10px;">${data.message}</div>`;
                            $('#alertmessageinnerbuy').html(elem).fadeIn('slow');
                            setTimeout(() => {
                                $('#alertmessageinnerbuy').fadeOut('slow');
                            }, 2000);
                        }
                    }
                })
            }
            
        })







    });


</script>



@endsection