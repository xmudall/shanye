<?php
class ContactController extends ApplicationController
{
    public function indexAction($id=0) {
        if ($this->request->isGet()) {
            if ($id == 0) {
                $contacts = Contact::find();
                $data = array();
                foreach ( $contacts as $contact ) {
                    $data[] = array(
                        'id' => $contact->id,
                        'name' => $contact->name,
                        'phone' => $contact->phone,
                        'email' => $contact->email,
                        'smid' => $contact->smid,
                        'company' => $contact->company,
                        'position' => $contact->position,
                        'industry' => $contact->industry,
                        'shanye_time' => $contact->shanye_time,
                        'school_time' => $contact->school_time,
                        'wishes' => $contact->wishes,
                    );
                }
                $this->returnJson($data);
            } else {
                $contact = Contact::findFirst($id);
                $data = array(
                    'id' => $contact->id,
                    'name' => $contact->name,
                    'phone' => $contact->phone,
                    'email' => $contact->email,
                    'smid' => $contact->smid,
                    'company' => $contact->company,
                    'position' => $contact->position,
                    'industry' => $contact->industry,
                    'shanye_time' => $contact->shanye_time,
                    'school_time' => $contact->school_time,
                    'wishes' => $contact->wishes,
                );
                $this->returnJson($data);
            }
        } else if ($this->request->isPost()) {
            if ($id == 0) {
                // add new contact
                $post = $this->request->getJsonRawBody();
                $contact = new Contact();
                $contact->name = $post->name;
                $contact->phone = $post->phone;
                $contact->email = $post->email;
                $contact->smid = $post->smid;
                $contact->company = $post->company;
                $contact->position = $post->position;
                $contact->industry = $post->industry;
                $contact->shanye_time = $post->shanye_time;
                $contact->school_time = $post->school_time;
                $contact->wishes = $post->wishes;
                $contact->password = $post->password;
                if ($contact->save() == false) {
                    foreach ($Contact->getMessages as $msg) {
                        error_log($msg."\n");
                    }
                    $this->returnError("保存个人信息失败，请联系管理员或稍后再试");
                } else {
                    $this->returnSuccess();
                }
            } else {
                // edit Contact
                $post = $this->request->getJsonRawBody();
                $contact = Contact::findFirst($id);
                if ( empty($contact) ) {
                    $this->returnError("要修改的信息不存在"); 
                    return;
                }
                if ($contact->password != $post->password) {
                    $this->returnError("密码错误，请重新输入"); 
                    return;
                }
                $contact->name = $post->name;
                $contact->phone = $post->phone;
                $contact->email = $post->email;
                $contact->smid = $post->smid;
                $contact->company = $post->company;
                $contact->position = $post->position;
                $contact->industry = $post->industry;
                $contact->shanye_time = $post->shanye_time;
                $contact->school_time = $post->school_time;
                $contact->wishes = $post->wishes;
                if ($contact->save() == false) {
                    foreach ($Contact->getMessages as $msg) {
                        error_log($msg."\n");
                    }
                    $this->returnError("保存个人信息失败，请联系管理员或稍后再试");
                } else {
                    $this->returnSuccess();
                }
            }
        }
    }

    public function addAction($id = -1) {
        if ( $id == -1 || !$this->is_unsigned_integer($id)) {
            return $this->errorResponse(40001, 'Invalid id');
        }
        $customer = Contact::findFirst($id);
        if ($customer != null) {
            if ( $this->request->isPost() ) {
                error_log(json_encode($_POST));
                // return $this->dispatcher->forward(array(
                //     'controller' => 'customer',
                //     'action' => 'index',
                // ));
            } else {
                $this->view->obj = $customer;
            }
        } else {
            return $this->errorResponse(40003, 'The record doesn`t exist');
        }
    }

    public function deleteAction($id = -1) {
        if ( $id == -1 || !$this->is_unsigned_integer($id)) {
            return $this->errorResponse(40001, 'Invalid id');
        }
        $customer = Contact::findFirst($id);
        if ($customer != null) {
            if ($customer->delete() == false) {
                return $this->errorResponse(40002, 'Delete failed');
            } else {
                return $this->returnJson( array('success'=>true) );
            }
        } else {
            return $this->errorResponse(40003, 'The record doesn`t exist');
        }

    }

    public function editAction($id = -1) {
        if ( $id == -1 || !$this->is_unsigned_integer($id)) {
            return $this->errorResponse(40001, 'Invalid id');
        }
        $customer = Contact::findFirst($id);
        if ($customer != null) {
            if ( $this->request->isPost() ) {
                error_log(json_encode($_POST));
                // return $this->dispatcher->forward(array(
                //     'controller' => 'customer',
                //     'action' => 'index',
                // ));
            } else {
                $this->view->obj = $customer;
            }
        } else {
            return $this->errorResponse(40003, 'The record doesn`t exist');
        }
    }
}
