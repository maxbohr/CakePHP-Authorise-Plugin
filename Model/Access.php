<?php
App::uses('AuthoriseAppModel', 'Authorise.Model');
App::uses('AuthComponent', 'Controller/Component');

class Access extends AuthoriseAppModel {
    
    public function isAuthorized($request, $user) {
        
        $options = array();
        $options['order'] = array('order' => 'ASC');
        $access_rules = $this->find('all', $options);
        
        // Not rules set - Open all gates
        if(empty($access_rules)) {
            return true;
        }
        
        if($request->url === false) {
            return true;
        }
        if($request->action == 'logout') {
            return true;
        }
        
        $controller = Inflector::slug($request->controller);
        $action = Inflector::slug($request->action);
        
        $is_authorized = false;
        $access_rule_used = false;
        
        foreach($access_rules as $access_rule) {
            
            $field = $access_rule['Access']['field'];
            $value = $access_rule['Access']['value'];
            $is_qualified_user = false;
            if($field == '*') {
                $is_qualified_user = true;
            }
            if(isset($user[$field]) && $user[$field] == $value) {
                $is_qualified_user = true;
            }
            if(!$is_qualified_user) {
                continue;
            }
            
            // User is qualified to match
            
            $is_qualified_record = false;
            switch(true) {
                case $access_rule['Access']['controller'] == '*':
                    $is_qualified_record = true;
                    break;
                case @$access_rule['Access']['controller'] == $controller && @$access_rule['Access']['action'] == '*':
                    $is_qualified_record = true;
                    break;
                case @$access_rule['Access']['controller'] == $controller && @$access_rule['Access']['action'] == $action:
                    $is_qualified_record = true;
                    break;
            }
            if(!$is_qualified_record) {
                continue;
            }
            
            // User and Request Matches
            $access_rule_used = $access_rule['Access'];
            
            if(@$access_rule['Access']['rule'] == 'deny') {
                $is_authorized = false;
            }
            else {
                $is_authorized = true;
            }
            break;
            
        }
        
        // $this->AccessLog = ClassRegistry::init('Authorise.AccessLog');
        if(Configure::read('debug') == 2) {
            $log = array('AccessLog' => array(
                'user' => $user,
                'request' => $request,
                'is_authorized' => $is_authorized,
                'access_rule' => $access_rule_used,
            ));
            CakeLog::write('access_log', json_encode($log));
        }
        // $this->AccessLog->save($log);
        
        
        return $is_authorized;
  
    }
    
    public function beforeSave($options = array()) {
        if(!empty($this->data[$this->alias]['order'])) {
            $this->data[$this->alias]['order'] = intval($this->data[$this->alias]['order']);
        }
    }
    
}
