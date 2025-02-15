<?php
    class Request{
        public $inputs=[];public $errors=[];
        public $current_url=null;
        public function __construct($url=null, $method=null){
            $postdata =null;
            $contentType = $_SERVER["CONTENT_TYPE"] ?? '';
            if($method == 'POST'){
                if(!empty($contentType) && strpos($contentType, 'application/json') !== false) {
                    $postdata = file_get_contents("php://input");
                    $this->inputs = !empty($postdata) ? json_decode($postdata) : null;
                }
                else{
                    $this->inputs = (object)$_POST;
                }
               
            }
            else if($method == 'GET')
            {
                    $request_info=[];
                    foreach($_GET as $key => $value){
                        $request_info[$key]=$value;
                    }
                    $request_info['params'] = $_GET;
                    $this->inputs = (object)($request_info);
                    
            }
            if($this->inputs){
                $this->inputs->_method = $method;
                $this->inputs->url = $url;
            }
            $this->current_url=$url;
            SessionManagement::setUserRequestSession($this);
        }
        public function __get($name){
            return is_string($this->inputs->$name ?? null) ? strip_tags($this->inputs->$name) : ($this->inputs->$name ?? '');
        }
        public function validate($rules){
            foreach($rules as $field => $rule_params){
                $rules_exp = explode('|', $rule_params);
                foreach($rules_exp as $rule){
                    if($rule == 'required' && empty($this->inputs->$field)){
                        $this->errors[] = $field . ' is required';
                    }
                    if($rule == 'array' && !is_array($this->inputs->$field)){
                        $this->errors[] = $field . ' must be an array';
                    }
                    if($rule == 'number'){
                        if(!is_numeric($this->inputs->$field)){
                            $this->errors[] = $field . ' must be numeric';
                        }
                    }
                    if(!empty($this->inputs->$field) &&  str_starts_with($rule, 'max:')){
                        $length = str_replace('max:', '', $rule);
                        if(strlen($this->inputs->$field) > $length){                
                            $this->errors[] = $field . ' must be less than ' . $length . ' characters';
                        }
                    }
                    if(!empty($this->inputs->$field) &&  str_starts_with($rule, 'min:')){
                        $length = str_replace('min:', '', $rule);
                        if(strlen($this->inputs->$field) < $length){                
                            $this->errors[] = $field . ' must be greater than ' . $length . ' characters';
                        }
                    }
                    if(!empty($this->inputs->$field) &&  str_starts_with($rule, 'equal:')){
                        $length = str_replace('equal:', '', $rule);
                        if(strlen($this->inputs->$field) != $length){                
                            $this->errors[] = $field . ' must be equal to ' . $length . ' characters';
                        }
                    }
                    if($rule == 'alpha_num' && !empty($this->inputs->$field) && !$this->isValidAlphaNumeric($this->inputs->$field)){
                        $this->errors[] = $field . ' must be alpha numeric';
                    }
                    if($rule == 'alpha' && !empty($this->inputs->$field) && !$this->isValidStringWithSpaces($this->inputs->$field)){
                        $this->errors[] = $field . ' must be alpha';
                    }
                    if($rule == 'text_only' && !empty($this->inputs->$field) && !$this->isValidTextOnly($this->inputs->$field)){
                        $this->errors[] = $field . ' must be text only';
                    }
                    if($rule == 'email' && !empty($this->inputs->$field) && !filter_var($this->inputs->$field, FILTER_VALIDATE_EMAIL)){
                        $this->errors[] = $this->$field . ' is not valid email';
                    }
                    if( !empty($this->inputs->$field) &&  str_starts_with($rule, 'unique:')){
                        [$table, $column] = explode(',', $rule);
                        $table = str_replace('unique:', '', $table);
                        if (!$this->validateUnique($table, $column, $this->inputs->$field)) {
                            $this->errors[] = "{$field} must be unique.";
                        }
                    }
                }
            }
            if (count($this->errors) > 0) {
                JsonResponse::error('Validation failed', 400, $this->errors);
            }
            return true;
        }
        private function isValidAlphaNumeric($input) {
            return preg_match("/^[a-zA-Z0-9 ]+$/", $input);
        }
        private function isValidStringWithSpaces($input) {
            return preg_match("/^[a-zA-Z ]+$/", $input);
        }
        function isValidTextOnly($input) {
            return preg_match("/^[a-zA-Z]+$/", $input);
        }
        private function validateUnique($table, $column, $value) {
            $db=new DBQuery();
            $isExist =$db->setTable($table)->where($column, $value)->first();
            if(!empty($isExist->id)){
                return false;
            }
            return true;
        }
    }
?>