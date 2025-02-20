
<p id="message_error" style="color:red;"></p>
<p id="message_success" style="color:green;"></p>
<form method="post" id="verificationForm">
    @csrf
    <input type="hidden" name="email" value="{{ $email }}">
    <input type="number" name="otp" placeholder="Enter OTP" required>
    <br><br>
    <input type="submit" value="Verify">

</form>

<p class="time"></p>

<button id="resendOtpVerification">Resend Verification OTP</button>

<script src="{{ asset('js/jquery.js') }}"></script>

<script>

    $(document).ready(function(){
        $('#verificationForm').submit(function(e){
            e.preventDefault();

            var formData = $(this).serialize();

            $.ajax({
                url:"{{ route('account.forgotVerifiedOtp') }}",
                type:"POST",
                data: formData,
                success:function(res){
                    if(res.success){
                        alert(res.msg);
                        window.open("/account/reset-password","_self");
                    }
                    else{
                        $('#message_error').text(res.msg);
                        setTimeout(() => {
                            $('#message_error').text('');
                        }, 3000);
                    }
                }
            });

        });

        $('#resendOtpVerification').click(function(){
            $(this).text('Wait...');
            var userMail = @json($email);

            $.ajax({
                url:"{{ route('account.forgotResendOtp') }}",
                type:"GET",
                data: {email:userMail },
                success:function(res){
                    $('#resendOtpVerification').text('Resend Verification OTP');
                    if(res.success){
                        timer();
                        $('#message_success').text(res.msg);
                        setTimeout(() => {
                            $('#message_success').text('');
                        }, 3000);
                    }
                    else{
                        $('#message_error').text(res.msg);
                        setTimeout(() => {
                            $('#message_error').text('');
                        }, 3000);
                    }
                }
            });

        });
    });

    function timer()
    {
        var seconds = 30;
        var minutes = 1;

        var timer = setInterval(() => {
            if(minutes < 0){
                $('.time').text('');
                clearInterval(timer);
            }
            else{
                let tempMinutes = minutes.toString().length > 1? minutes:'0'+minutes;
                let tempSeconds = seconds.toString().length > 1? seconds:'0'+seconds;

                $('.time').text(tempMinutes+':'+tempSeconds);
            }
            if(seconds <= 0){
                minutes--;
                seconds = 59;
            }
            seconds--;
        }, 1000);
    }

    timer();

</script>
