<?php
// use Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Pagination\LengthAwarePaginator as Pagination;

;
date_default_timezone_set('Asia/Jakarta');

function debug($var = "hello")
{
    die(var_dump($var));
}


function setSuccess($text)
{
    Session::flash('successNotification', "$text");


}

function setDanger($text)
{
    Session::flash('dangerNotification', "$text");

}


function getHighlight($needle, $haystack, $format = false)
{
    $needle = ucwords($needle);
    $haystack = ucwords($haystack);
    if ($format) {
        $needle = getSearchFormat($needle);
    }
    // debug($needle.$haystack);
    return str_replace($needle, "<span style='background-color:yellow;'><b>$needle</b></span>", $haystack);
}


function getUrlFormat($string)
{
    $string = preg_replace('/[^\w\s]/', "", $string);
    $string = preg_replace('/\s+/', "-", $string);
    $string = strtolower($string);
    // debug($string);
    return $string;
}

function getNameFormat($string)
{
    $string = str_replace("-", " ", $string);
    $string = preg_replace("/\s+/", " ", $string);
    $string = ucwords(strtolower($string));
    return $string;
}

function dateTimeToString($source, $format = "D d-M")
{
    date_default_timezone_set('Asia/Jakarta');
    $date = new DateTime($source);
    return $date->format($format); // 31.07.2012

}

function getDefaultDatetime($str = null, $format = "Y-m-d H:i:s")
{
    date_default_timezone_set('Asia/Jakarta');
    if ($str == NULL) {
        return date($format, time());

    } else {
        return date($format, strtotime($str));

    }
}

function getSearchFormat($str)
{
    $str = strip_tags($str, '<br>'); //# kcuali br
    $str = str_replace('<br>', ' ', $str); //# br jadi space
    // $str = preg_replace('/[^a-zA-Z\s]/','',$str); //# trims non word but not space
    // $str = preg_replace('/[\s+]/',' ',$str); //# trims spaces and non word
    $str = preg_replace('/[^a-zA-Z]/', '', $str); //# trims everything
    $str = strtolower($str);
    // debug($str);
    return $str;
}


function pagination(Pagination $pagination)
{
    /*
     * totalData	: data dari table
     * fetch		: data per page
     * threshold	: deretan pagination
     * last			: pagination terakhir
     *
     * start	: terawal dari current
     * end		: terjuh dari pagination
     *
     *
     */

    $pagination->appends(Illuminate\Support\Facades\Input::except(['page']));

    $totalData = $pagination->total();
    $fetch = $pagination->perPage();
    $threshold = 3;
    $last = ceil($totalData / $fetch);
    $current = $pagination->currentPage();
    // debug($pagination->url(1));
    $start = ($current - $threshold >= $threshold ? $current - $threshold : 1);
    $end = ($current + $threshold >= $last ? $last : $current + $threshold);


    $list = "
             <a href='{$pagination->previousPageUrl()}' class='prev'>Previous</a>
                        <a href='{$pagination->nextPageUrl()}' class='next'>Next</a>
        ";


    return $list;
}


function saveEvent($message, $user = true)
{
    $event = new App\Model\Event();

    if ($user) {
        $user = Auth::user();;
    }
    $event->detail = $message;
    // debug(getDefaultDatetime());
    $event->created_at = getDefaultDatetime();

    $event->getUser()->associate($user);
    $event->save();
}

function hexToRgb($color)
{
    $hex = $color;
    $hex = list($r, $g, $b) = sscanf($hex, "#%02x%02x%02x");
    return $hex;
//        echo "$hex -> $r $g $b";
}

function createDirIfNotExist($path)
{
    if (!is_dir($path)) {
//            debug($path);

        mkdir($path, 0777, true);
    }

}

function publicAsset($target)
{

    $v= getDefaultDatetime();


    return asset("public/$target?v=$v");
}

function savePhoto($photoRequest, $path, $width = 300): App\Model\Photo
{
    $name = str_random(8);
    $nameThumbnail = $name . "-small" . "." . $photoRequest->extension();
    $name .= "." . $photoRequest->extension();
    $img = Image::make($photoRequest);
    $img->resize($width * 2, null, function ($constraint) {
        $constraint->aspectRatio();
    })->save($path . $name);
    $img->resize($width, null, function ($constraint) {
        $constraint->aspectRatio();
    })->save($path . $nameThumbnail);

    $photo = new App\Model\Photo();
    $photo->path = $path;
    $photo->nameLg = $name;
    $photo->nameSm = $nameThumbnail;
    $photo->save();


    return $photo;

}

function getSemicolonFormat($target)
{
    if (is_array($target)) {
        $value = "";
        foreach ($target as $current) {
            $value .= "$current;";
        }
        return $value;
    } else {
        return $target;
    }
}

function getReadableSemicolonFormat($target)
{
    $target = explode(';', $target);
    $target = join(' ', $target);
    return $target;
}




function addHistory(\App\Model\User $user, \App\Model\SelectEvent $event,  $description){

    if($user && $event){
        $history = new \App\Model\History();

        $history->getEvent()->associate($event);
        $history->description = $description;
        $history->getUser()->associate($user);

        $history->save();
    }


}

/**
 * @param $array
 * @param $key string
 * @param $value string
 *
 * return any array of [] = {key=>$key, value=>$value}
 * @return array
 */
function getKeyValue($array, $key, $value, $keyCallback){
    $keyValue = [];

    foreach($array as $currentArray){
        $keyValue[] = [
            'key' => $currentArray[$key],
            'value' => $currentArray[$value],
            'display' => (is_callable($keyCallback) ? $keyCallback($currentArray) : $currentArray[$key] )
        ];
    }

    return $keyValue;
}

function getDefaultResponse()
{
    $response = (object)[];
    $response->message = "";
    $response->isSuccess = true;
    $response->data = (object)[];

    return $response;
}


function getStrLimit($value, $limit = 200, $end = '...')
{
    $limit = $limit - mb_strlen($end); // Take into account $end string into the limit
    $valuelen = mb_strlen($value);
    return $limit < $valuelen ? mb_substr($value, 0, mb_strrpos($value, ' ', $limit - $valuelen)) . $end : $value;
}



/**
 *
 * @param Array $list
 * @param int $p
 * @return multitype:multitype:
 * @link http://www.php.net/manual/en/function.array-chunk.php#75022
 */
function getPartition(Array $list, $p) {
    $listlen = count($list);
    $partlen = floor($listlen / $p);
    $partrem = $listlen % $p;
    $partition = array();
    $mark = 0;
    for($px = 0; $px < $p; $px ++) {
        $incr = ($px < $partrem) ? $partlen + 1 : $partlen;
        $partition[$px] = array_slice($list, $mark, $incr);
        $mark += $incr;
    }
    return $partition;
}


class ApiResponse
{
    public $message = "Success";
    public $isSuccess = true;
    public $data;

    public function __construct(){
        $this->data = (object)[];
    }
}

?>
