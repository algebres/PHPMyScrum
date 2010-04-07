<?php
class AppError extends ErrorHandler
{
        function sys_error()
        {
                $this->_outputMessage('sys_error');
        }
}
