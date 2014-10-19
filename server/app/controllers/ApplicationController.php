<?php
/*
 * Controller 的公共父类，提供一些通用的功能，例如处理异常，返回错误信息等
 * Author: Udall
 *
 */

class ApplicationController extends \Phalcon\Mvc\Controller
{
    public function initialize() {
        $this->view->baseUrl = 'http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER["SERVER_PORT"].$this->url->getBaseUri();
    }

    protected function returnError($errmsg="") {
        $arr = array(
            'success' => false,
            'errormsg' => $errmsg,
        );
        $this->returnJson($arr);
    }    

    protected function returnSuccess() {
        $arr = array(
            'success' => true,
        );
        $this->returnJson($arr);
    }    

    protected function returnJson($jsonObj) {
        $this->response->setContentType("application/json", "UTF-8");
        $this->response->setContent(json_encode($jsonObj));
        $this->response->send();
    }

    protected function is_unsigned_integer($val) {
        $val=str_replace(" ","",trim($val));
        return eregi("^([0-9])+$",$val);
    }
}
