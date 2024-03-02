
<?php

use App\Models\MailQueue;
use App\Models\Ticket;
use App\Models\UserDepartment;
use App\Models\UserPermission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;



function array_assoc_value_exists($arr, $index, $search)
{
    foreach ($arr as $key => $value) {
        if ($value->$index == $search) {
            return TRUE;
        }
    }
    return FALSE;
}



function send_to_sendmail_service($email, $subject, $body, $url)
{
    require_once(base_path()  . '/vendor/twisted1919/mailwizz-php-sdk/MailWizzApi/autoload.php');
    $config = new MailWizzApi_Config(array(
        'apiUrl'        => 'http://sendmail.sunrise-resorts.com/api/index.php',
        'publicKey'     => '1b42151f0d7e9ee88463b5c8a30e87a1fe9aa250',
        'privateKey'    => '9d6bcb78f6393c48a04266b1291c1ffb01077664'

    ));
    MailWizzApi_Base::setConfig($config);
    date_default_timezone_set('UTC');
    $endpoint = new MailWizzApi_Endpoint_TransactionalEmails();
    $response = $endpoint->create(array(
        'to_name'           => $email, // required
        'to_email'          => $email, // required
        'from_name'         => 'Let Us Know', // required
        'subject'           => $subject, // required
        'body'              => $body, // required
        'send_at'           => date('Y-m-d H:i:s'),  // required, UTC date time in same format!
    ));

    // $send_message_request = [
    //   'phone' => '201068267949',
    //   'body' => strip_tags($body),
    // ];
    // $apiInstance->sendMessage($send_message_request);

}

function whatsapp($phone, $message)
{

    require_once(base_path() . '/vendor/sailing2014/chat-api-sdk-php/vendor/autoload.php');
    $config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setApiKey('instanceId', '83685');
    $config = OpenAPI\Client\Configuration::getDefaultConfiguration()->setApiKey('token', 'oas6j80hai7x1igb');
    $apiInstance = new OpenAPI\Client\Api\Class2MessagesApi(new GuzzleHttp\Client(), $config);
    // $module_name = modules::get_model_by_id($module_id)->name;
    // $url = url($module_name . '/' . $form_id);
    $body = 'LetUsKnow';
    $send_message_request = [
        'phone' =>  $phone,
        'body' => strip_tags($message),
    ];
    $apiInstance->sendMessage($send_message_request);
}

function checkPermission($module_id)
{
    $permission =  UserPermission::where(['module_id' => $module_id, 'u_id' => Auth::id()])->first();
    if (isset($permission->view)) {

        if ($permission->view == 1) {
            return  true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}


function getPhoneForMail($survey_id)
{
    $data  = MailQueue::where(['survey_id' => $survey_id, 'type' => 14])->first();
    return $data;
}


function uploadImage($folder, $image)
{
    $image->store('/', $folder);
    $filename = $image->hashName();
    return  $filename;
}



function check_create_permission($module_id)
{
    $permission = UserPermission::select('*')->where(['u_id' => Auth::id(), 'module_id' => $module_id])->first();
    if (isset($permission->create) && $permission->create == 1) {
        return true;
    } else {
        return false;
    }
}

function inDepartment($department_id)
{
    $user_department = UserDepartment::where(['dep_id' => $department_id, 'user_id' => Auth::user()])->first();
    if (is_null($user_department)) {
        return false;
    } else {
        return true;
    }
}



function get_time_diff($created_at, $end_at)
{
    // $from = new DateTime('2006-04-12T01:30:00');
    // ($end_at != null) ? $to = new DateTime('2006-04-12T02:20:00') : $to = new DateTime('2006-04-12T02:20:00');

    $from = new DateTime($created_at);
    ($end_at != null) ? $to = new DateTime($end_at) : $to = new DateTime();
    // dd($to);
    $diff = $to->diff($from);
    $min = $diff->format('%i');
    $hours =  $diff->format('%h');
    $days =  $diff->format('%a');

    $time = '';
    if ($days > 0) {
        $time = $diff->format('%a:%H:%i');
    } else {
        $time = $diff->format('%H:%i');
    }


    $color = '#ced6e0';

    if ($hours  >= "1"  || $days  >= "1") {
        $color =  '#181a1b';
    } else {
        if ("19" < $min  &&  $min  < "30") { //Blue
            $color = '#0f74e7';
        } elseif ("29" < $min   && $min < "40") { //Yellow
            $color = '#f1c40f';
        } elseif ("39" < $min   && $min < "50") { //Orange
            $color = '#e75e0f';
        } elseif ("49" < $min   && $min < "60") { //red
            $color = '#e70f0f';
        }
    }



    $result = [
        'time' =>  $time,
        'color' => $color
    ];

    return $result;
}

function get_month_name($number)
{
    $dateObj   = DateTime::createFromFormat('!m', $number);
    $monthName = $dateObj->format('F');
    return $monthName;
}


function get_service_count($hotel_id, $service_id, $month = False)
{
    $result =  Ticket::where(['hid' =>  $hotel_id, 'service_id' =>  $service_id, 'deleted' => 0])->whereYear('created_at', date('Y'));
    if ($month) {
        $result->WhereMonth('created_at',  $month);
    }
    return $result->count();
}

