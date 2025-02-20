<?php


use App\Http\Middleware\VerifyUser;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\admin\LoginController as AdminLoginController;
use App\Http\Controllers\admin\DashboardController as AdminDashboardController;

// use Illuminate\Support\Facades\Config;
// use Srmklive\PayPal\Services\PayPal as PayPalClient;


Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'account'],function() {
    // Guest Middleware
    Route::group(['middleware' => 'guest'],function() {
        Route::get('login',[LoginController::class,'index'])->name('account.login');
        Route::post('authenticate',[LoginController::class,'authenticate'])->name('account.authenticate');
        Route::get('register',[LoginController::class,'register'])->name('account.register');
        Route::post('process-register',[LoginController::class,'processRegister'])->name('account.processRegister');
        // Route::get('sendemail',[MailController::class,'sendEmail']);
        
        Route::get('forgot-password',[LoginController::class,'forgotPassword'])->name('account.forgotpassword'); // page that get opened after forgot password click
        Route::post('/forgot-verification',[LoginController::class,'forgotVerification'])->name('account.forgotverify'); // verification page that get opened after forgot password next click after giving registered email
        Route::post('/forgot-verified',[LoginController::class,'forgotVerifiedOtp'])->name('account.forgotVerifiedOtp'); // on click of verify button of verification page
        Route::get('/forgot-resend-otp',[LoginController::class,'forgotResendOtp'])->name('account.forgotResendOtp'); // on click of resend verification button of verification page
        
        
        
    });
    
    // Authenticated Middleware
    Route::group(['middleware' => 'auth'],function() {
        Route::get('/verification',[LoginController::class,'verification'])->name('account.verify'); // verification page that get opened after registration
        Route::post('/verified',[LoginController::class,'verifiedOtp'])->name('account.verifiedOtp'); // on click of verify button of verification page
        Route::get('/resend-otp',[LoginController::class,'resendOtp'])->name('account.resendOtp'); // on click of resend verification button of verification page
        
        
        Route::get('logout',[LoginController::class,'logout'])->name('account.logout')->middleware(VerifyUser::class);
        Route::get('reset-password',[LoginController::class,'resetPassword'])->name('account.resetpassword')->middleware(VerifyUser::class); // open reset password form
        Route::post('process-reset-password',[LoginController::class,'processResetPassword'])->name('account.processresetpassword')->middleware(VerifyUser::class); // open reset password form

        // Free Exam
        Route::get('dashboard',[DashboardController::class,'index'])->name('account.dashboard')->middleware(VerifyUser::class);
        // Paid Exam
        Route::get('paid-exam',[DashboardController::class,'paidExam'])->name('account.paidExam')->middleware(VerifyUser::class);
        
        
        Route::get('exam/{id}',[ExamController::class,'loadExamDashboard'])->name('account.loadExamDashboard')->middleware(VerifyUser::class);
        Route::post('exam-submit',[ExamController::class,'examSubmit'])->name('account.examSubmit')->middleware(VerifyUser::class);
        
        
        Route::get('results',[DashboardController::class,'resultsView'])->name('account.resultsView')->middleware(VerifyUser::class);
        Route::get('student/review',[DashboardController::class,'stuReviewQNA'])->name('account.stuReviewQNA')->middleware(VerifyUser::class);
        
        // Payments
        // Razorpay - INR
        Route::post('payment-inr',[DashboardController::class,'paymentInr'])->name('account.paymentInr')->middleware(VerifyUser::class);
        Route::get('payment-success',[DashboardController::class,'paymentSuccess'])->name('account.paymentSuccess')->middleware(VerifyUser::class);
        Route::get('verify-payment',[DashboardController::class,'varifyPayment'])->name('account.varifyPayment')->middleware(VerifyUser::class);
        
        // Paypal - USD
        Route::post('paypal', [DashboardController::class, 'paypal'])->name('account.paypal');
        Route::get('success', [DashboardController::class, 'success'])->name('account.success');
        Route::get('cancel', [DashboardController::class, 'cancel'])->name('account.cancel');

        
    });
});

Route::group(['prefix' => 'admin'],function() {
    // Guest Middleware for admin
    Route::group(['middleware' => 'admin.guest'],function() {
        Route::get('login',[AdminLoginController::class,'index'])->name('admin.login');
        Route::post('authenticate',[AdminLoginController::class,'authenticate'])->name('admin.authenticate');
        Route::get('register',[AdminLoginController::class,'register'])->name('admin.register');
        Route::post('process-register',[AdminLoginController::class,'processRegister'])->name('admin.processRegister');
    });

    // Authenticated Middleware for admin
    Route::group(['middleware' => 'admin.auth'],function() {
        Route::get('logout',[AdminLoginController::class,'logout'])->name('admin.logout');
        
        
        Route::get('dashboard',[AdminDashboardController::class,'index'])->name('admin.dashboard');
        Route::get('list-subjects',[AdminDashboardController::class,'listSubjects'])->name('admin.listSubjects');
        Route::post('add-subject',[AdminDashboardController::class,'addSubject'])->name('admin.addSubject');
        Route::post('update-subject',[AdminDashboardController::class,'updateSubject'])->name('admin.updateSubject');
        Route::post('delete-subject',[AdminDashboardController::class,'deleteSubject'])->name('admin.deleteSubject');
        
        
        Route::get('exams',[AdminDashboardController::class,'viewExams'])->name('admin.viewExams');
        Route::get('list-exams',[AdminDashboardController::class,'listExams'])->name('admin.listExams');
        Route::post('add-exam',[AdminDashboardController::class,'addExam'])->name('admin.addExam');
        Route::get('update-exam-modal',[AdminDashboardController::class,'updateExamModal'])->name('admin.updateExamModal');
        Route::post('update-exam',[AdminDashboardController::class,'updateExam'])->name('admin.updateExam');
        Route::post('delete-exam',[AdminDashboardController::class,'deleteExam'])->name('admin.deleteExam');
        
        // Get questions on add question button click in exam view
        Route::get('get-questions',[AdminDashboardController::class,'getQuestions'])->name('admin.getQuestions');
        Route::post('add-questions',[AdminDashboardController::class,'addQuestions'])->name('admin.addQuestions');
        // show questions linked to a particular exam
        Route::get('show-questions',[AdminDashboardController::class,'showQuestions'])->name('admin.showQuestions');
        Route::get('delete-question',[AdminDashboardController::class,'deleteQuestion'])->name('admin.deleteQuestion');
        
        
        
        Route::get('qna',[AdminDashboardController::class,'viewQNA'])->name('admin.viewQNA');
        Route::get('list-qna',[AdminDashboardController::class,'listQNA'])->name('admin.listQNAs');
        Route::post('add-qna',[AdminDashboardController::class,'addQNA'])->name('admin.addQNA');
        Route::post('import-qna',[AdminDashboardController::class,'importQNA'])->name('admin.importQNA');
        Route::get('show-ans-modal',[AdminDashboardController::class,'showAnsModal'])->name('admin.showAnsModal');
        Route::get('update-qna-modal',[AdminDashboardController::class,'updateQNAModal'])->name('admin.updateQNAModal');
        Route::get('remove-ans',[AdminDashboardController::class,'removeAns'])->name('admin.removeAns');
        Route::post('update-qna',[AdminDashboardController::class,'updateQNA'])->name('admin.updateQNA');
        Route::post('delete-qna',[AdminDashboardController::class,'deleteQNA'])->name('admin.deleteQNA');
        
        
        
        
        Route::get('students',[AdminDashboardController::class,'viewStudents'])->name('admin.viewStudents');
        Route::get('list-students',[AdminDashboardController::class,'listStudents'])->name('admin.listStudents');
        Route::get('export-students',[AdminDashboardController::class,'exportStudents'])->name('admin.exportStudents');
        
        
        Route::get('marks',[AdminDashboardController::class,'viewMarks'])->name('admin.viewMarks');
        Route::get('list-marks',[AdminDashboardController::class,'listMarks'])->name('admin.listMarks');
        Route::get('update-marks-modal',[AdminDashboardController::class,'updateMarksModal'])->name('admin.updateMarksModal');
        Route::post('update-marks',[AdminDashboardController::class,'updateMarks'])->name('admin.updateMarks');
        
        
        
        
        Route::get('review-exam',[AdminDashboardController::class,'viewReview'])->name('admin.viewReview');
        Route::get('list-exam-review',[AdminDashboardController::class,'listExamReview'])->name('admin.listExamReview');
        Route::get('get-reviewed-qna',[AdminDashboardController::class,'reviewQNA'])->name('admin.reviewQNA');
        Route::post('approved-qna',[AdminDashboardController::class,'approvedQNA'])->name('admin.approvedQNA');

        
        
    });
});



