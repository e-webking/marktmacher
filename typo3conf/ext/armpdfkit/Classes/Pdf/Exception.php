<?php
namespace ARM\Armpdfkit\Pdf;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Exception extends \Exception 
{
    public function __construct($message, $code, $previous) {
        parent::__construct($message, $code, $previous);
    }
}