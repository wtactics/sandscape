<?php
class error_controller extends rpd {

    function error_message($message)
    {
        if ($message=='404')
        {
                $page = '404';
        }
        else
        {
                $page = 'error';
                $message = array('error'=>$message);
        }
        echo $this->view('errors/'.$page, $message);
    }


}
?>