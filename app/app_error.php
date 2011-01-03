<?php

class AppError extends ErrorHandler {

    function sys_error($params = array()) {
        $message = @$params['message'];
        if ($message == "") {
            $message = __('System Error', true);
        }
        $this->controller->set('message', $message);
        $this->_outputMessage('sys_error');
    }

}

?>