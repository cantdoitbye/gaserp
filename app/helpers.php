<?php 
use Carbon\Carbon;
use App\Models\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;














define('PROJECT_START_DATE', '2024-08-28');
define('TIME_FORMAT', 'Y-m-d H:i:s');
define('ADMIN', 1);
define('SUBADMIN', 2);



// define('firebasecredentails', base_path('firebase-credentials.json'));


function defaultImage() {
    return url('/') . "/assets/img/no-image.jpg";
}

function version() {
    return "2.8.4";
}

function base64Encode($value) {
    return base64_encode(base64_encode($value));
}

function base64Decode($value) {
    return base64_decode(base64_decode($value));
}

function ajaxSuccessResponse($status, $message = '', $data = []) {
    return [
        'success' => $status,
        'message' => $message,
        'data' => $data,
    ];
}
function ajaxResponse($status, $message = '', $data = []) {
    return [
        'data' => $data,
        'status' => $status,
        'message' => $message
    ];
}
function success($data, $message = 'Success', $code = 200)
{
    return response()->json([
        'status' => true,
        'message' => $message,
        'data' => $data,
    ], $code);
}
function error($message = 'Error', $code = 400, $data = null)
    {
        return response()->json([
            'status' => false,
            'message' => $message,
            'data' => $data,
        ], $code);
    }


function defaultTimeZone() {

    return "Asia/kolkata";
}

function getAdminTimezone() {
      
            return defaultTimeZone();
        
    
}

function convertTimezoneToUTC($date) {
    $timezone = Session::get('UserTimeZone');
    if (!$timezone) {
        $timezone = getAdminTimezone();
    }
    return parseDisplayDateTime(Carbon::createFromFormat(TIME_FORMAT, $date, $timezone)->setTimezone('UTC'));
}

function convertUtcToTimezone($date) {
    $timezone = Session::get('UserTimeZone');
    if (!$timezone) {
        $timezone = getAdminTimezone();
    }
    return parseDisplayDateTime(Carbon::createFromFormat(TIME_FORMAT, $date, 'UTC')->setTimezone($timezone));
}

// function convertTimezoneToUTC($date) {
//     $timezone = defaultTimeZone();
//     return Carbon::parse($date, $timezone)->setTimezone('UTC');
// }



function dbTimezoneToUTC($date) {
   
        $timezone = defaultTimeZone();

    return Carbon::createFromFormat(TIME_FORMAT, $date, $timezone)->setTimezone('UTC');
}

function dbUtcToTimezone($date) {
 
        $timezone = defaultTimeZone();
  
    return Carbon::createFromFormat(TIME_FORMAT, $date, 'UTC')->setTimezone($timezone);
}

// function parseDisplayDate($date) {
//     return date('m/d/Y', strtotime($date));
// }

// function parseDisplayDateTime($date) {
//     return date('d/m/Y h:i A', strtotime($date));
// }
function parseDisplayDate($date) {
    return Carbon::parse($date)->format('d M, Y');
}

// function parseDisplayDateTime($date) {
//     return Carbon::parse($date)->format('d/m/Y h:i A');
// }
function parseDisplayDateTime($date) {
    return Carbon::parse($date)->format('d M, Y h:i A');
}

function parseDisplayDateNew($date) {
    return date('d M, Y', strtotime($date));
}

function parseDisplayTime($date) {
    return date('h:i A', strtotime($date));
}

function isDeleted() {
    if (isset(request()->deleted)) {
        return 'Deleted';
    }
    return '';
}

function generateOTP() {
    if (env('APP_ENV') != 'production') {
        $otp_code = 1234;
    } else {
        $otp_code = str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
    }

    return $otp_code;
}



function filterDateParameters($r) {
    $params['filterStartDate'] = $rStart = $r->filterStartDate ? $r->filterStartDate : PROJECT_START_DATE;
    $params['filterEndDate'] = $rEnd = $r->filterEndDate ? $r->filterEndDate : Carbon::now()->format('Y-m-d');
    $params['label'] = $label = $r->label ? $r->label : 'Lifetime';
    $params['filterStatus'] = $r->filterStatus ? $r->filterStatus : '';


    if ($label == "Today" || $label == "Yesterday" || $label == "Last 7 Days" || $label == "Last 30 Days" || $label == "Custom Range") {
        $start = dbTimezoneToUTC($rStart . " 00:00:00");
        $end = dbTimezoneToUTC($rEnd . " 23:59:59");
    } else {
        $start = $rStart . " 00:00:00";
        $end = $rEnd . " 23:59:59";
    }


    return compact('params', 'start', 'end', 'label');
}
function dateFilter($query, $r, $start, $end) {
    if (isset($r->filterStartDate) && isset($r->filterEndDate) && $r->filterStartDate != '' && $r->filterEndDate != '') {
        $query->whereDate('created_at', '>=', $start)->whereDate('created_at', '<=', $end);
    }
    return $query;
}


function globalDeleteFileUrl($image) {
    return Storage::disk('public')->delete($image);
}

function uploadBase64($directory, $prefix, $base64, $fileName = '')
{

    list($baseType, $image) = explode(';', $base64);
    list(, $image) = explode(',', $image);
    $image = base64_decode($image);
    $fileName = uniqid($prefix) . '.jpg';
    Storage::disk('public')->put("images/$directory/$fileName", $image, 'public');
    return ["images/$directory/$fileName"];
}



function uploadSingleDoc($doc, $directory, $prefix)
{

    $ext = "jpg";
    $ext = $doc->extension();

    $fileName = uniqid($prefix) . '.' . $ext;


    $filePath = "images/$directory/" . $fileName;

  Storage::disk('public')->put($filePath, file_get_contents($doc), 'public');
    // Storage::disk('public_folder')->put($filePath, file_get_contents($doc));

    return $filePath;
}
function uploadImage($file, $directory, $prefix, $sizes = []) {
    $ext = $file->getClientOriginalExtension();
    $fileName = uniqid($prefix) . '.' . $ext;
    $filePath = "$directory/" . $fileName;

    $img = Image::make($file->getRealPath());
    $encodedOriginal = $img->encode($ext);

    if ($encodedOriginal !== false) {
        Storage::disk('public')->put($filePath, $encodedOriginal->__toString());

        $result = [
            'original' => $filePath,
            'thumbnails' => []
        ];

        foreach ($sizes as $size) {
            $thumbnailPath = generateThumbnail($file, $directory, $prefix, $size);
            if ($thumbnailPath) {
                $result['thumbnails'][$size] = $thumbnailPath;
            }
        }

        return $result;
    }

    return null;
}
function generateThumbnail($image, $directory, $prefix, $size) {
    $img = Image::make($image->getRealPath());
    $ext = $image->getClientOriginalExtension();
    $fileName = uniqid($prefix . '_thumb_' . $size . '_') . '.' . $ext;
    $filePath = "$directory/thumbnails/" . $fileName;

    $img->resize($size, null, function ($constraint) {
        $constraint->aspectRatio();
        $constraint->upsize();
    });

    $encodedImage = $img->encode($ext);
    
    if ($encodedImage !== false) {
        Storage::disk('public')->put($filePath, $encodedImage->__toString());
        return $filePath;
    }

    return null;
}


function uploadMultipleDocs($docs, $directory, $prefix)
{
    $filePaths = [];

    foreach ($docs as $doc) {
        $ext = $doc->extension();

        $fileName = uniqid($prefix) . '.' . $ext;

        $filePath = "images/$directory/" . $fileName;

        Storage::disk('public')->put($filePath, file_get_contents($doc), 'public');

        $filePaths[] = $filePath;
    }

    return $filePaths;
}

function globalImageUrl($image){
    return asset('uploads/' . $image);
}

if (!function_exists('getBase64Image')) {
    function getBase64Image($imagePath) {
        if (file_exists($imagePath)) {
            $imageData = file_get_contents($imagePath);
            $type = pathinfo($imagePath, PATHINFO_EXTENSION);
            return 'data:image/' . $type . ';base64,' . base64_encode($imageData);
        }
        return null;
    }
}



