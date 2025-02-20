<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\ExamPayment;
use App\Models\UserAnswer;
use App\Models\ExamAttempt;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

use Razorpay\Api\Api;

class DashboardController extends Controller
{
    public function index() {
        $exams = Exam::with('subject')->where('plan','0')->orderBy('date','DESC')->get();
        return view('dashboard',compact('exams'));
    }
    public function paidExam() {
        $exams = Exam::with('subject','getPaidInformation')->where('plan','1')->orderBy('date','DESC')->get();
        return view('paid-exam',compact('exams'));
    }
    public function resultsView() {
        $attempts = ExamAttempt::where('user_id',Auth()->user()->id)->with('exam')->get();
        return view('view-results',compact('attempts'));
    }


    public function stuReviewQNA(Request $request){
        try{
            $attemptData = UserAnswer::where('attempt_id',$request->attempt_id)->with('question','question.answers','answers')->get();
            return response()->json([
                'status' => true,
                'message' => 'Fetched attempt data',
                'data' => $attemptData,
            ],200);
        }catch(\Exception $e){
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ],200);
        }

    }



    // Payments

    // Razorpay
    public function paymentInr(Request $request){
        try{
            $api = new Api(config('app.paymentkey'),config('app.secretkey'));

            // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
            $orderData = [
                'receipt' => 'rcptid_55',
                'amount' => $request->price.'00', 
                'currency' => 'INR',
                'notes'=> array('key1'=> 'value3','key2'=> 'value2')
            ];
            $razorpayOrder = $api->order->create($orderData); 

            return response()->json([
                'status' => true,
                'order_id' => $razorpayOrder['id'],
            ],200);
           

        }catch(\Exception $e){
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ],200);
        }
    }

    public function paymentSuccess(){
        return view('payment-success');

    }


    public function varifyPayment(Request $request){
        try{
            $api = new Api(config('app.paymentkey'),config('app.secretkey'));

            $attributes = [
                'razorpay_order_id' => $request->razorpay_order_id, 
                'razorpay_payment_id' => $request->razorpay_payment_id, 
                'razorpay_signature' => $request->razorpay_signature
            ];



            $api->utility->verifyPaymentSignature($attributes);

            ExamPayment::insert([
                'exam_id' => $request->exam_id,
                'user_id' => auth()->id(),
                'payment_details' => json_encode($attributes)
            ]);

            return response()->json([
                'status' => true,
                'message' => "Payment Successiful, Your Payment ID: ".$request->razorpay_payment_id
            ],200);
           

        }catch(\Exception $e){
            return response()->json([
                'status' => false,
                'message' => "Payment Failed".$e->getMessage(),
            ],200);
        }
    }

    
    // Paypal
    public function paypal(Request $request)
    {
        
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('account.success'),
                "cancel_url" => route('account.cancel')
            ],
            "purchase_units" => [
                [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => $request->price_paypal
                    ]
                ]
            ]
        ]);
        
        
        // //dd($response);
        if(isset($response['id']) && $response['id']!=null) {
            foreach($response['links'] as $link) {
                if($link['rel'] === 'approve') {
                    // session()->put('product_name', $request->product_name);
                    // session()->put('quantity', $request->quantity);
                    // return redirect()->away($link['href']);
                    session()->put('examid', $request->examid);
                    return response()->json([
                        'status' => true,
                        'link' => $link['href']
                    ],200);
                }
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => "Payment Failed",
            ],200);
        }
    }
    public function success(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request->token);
        //dd($response);
        if(isset($response['status']) && $response['status'] == 'COMPLETED') {
            // dd($request->all());
            // Insert data into database
            $attributes = [
                'payer_id' => $request->PayerID, 
            ];
            ExamPayment::insert([
                'exam_id' => session()->get('examid'),
                'user_id' => auth()->id(),
                'payment_details' => json_encode($attributes)
            ]);
            session()->forget('examid');
            // $payment = new Payment;
            // $payment->payment_id = $response['id'];
            // $payment->product_name = session()->get('product_name');
            // $payment->quantity = session()->get('quantity');
            // $payment->amount = $response['purchase_units'][0]['payments']['captures'][0]['amount']['value'];
            // $payment->currency = $response['purchase_units'][0]['payments']['captures'][0]['amount']['currency_code'];
            // $payment->payer_name = $response['payer']['name']['given_name'];
            // $payment->payer_email = $response['payer']['email_address'];
            // $payment->payment_status = $response['status'];
            // $payment->payment_method = "PayPal";
            // $payment->save();
            // unset($_SESSION['product_name']);
            // unset($_SESSION['quantity']);

            return redirect()->route('account.paidExam')->with('paypalsuccess','Payment is Successful');


        } else {
            return redirect()->route('cancel');
        }
    }
    public function cancel()
    {
        return redirect()->route('account.paidExam')->with('paypalfail','Payment is Cancelled');
    }



    // End Payments

    

    
}
