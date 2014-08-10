<?php
class db_engine extends db_manager{

    const ALL = true;
    const ONE = false;

    public $config_db;

    public function openConnection(){
        return parent::openConnection();
    }

    /*protected function model($criteria = array(), $type = 'ALL'){

    }*/

    /*private function buildQuery($criteria = array()){
        $queryArray = array(
            'select'=>null, //0-9=>field
            'from'=>null, //:a-z=>table || L: I: R: O:a-z=>table
            'join'=>null,
            'where'=>null, //:field=>value
        );

        foreach($criteria as $key=>$val){
            $type=$this->getCriteriaKeyType($key);
            if($type!=null){
                $queryArray[$type][]=$val;
            }
        }
    }

    protected function getCriteriaKeyType($key){
        $pattern = '((\d)|(\:[a-zA-Z_])|([L|I|R|O]\:[a-zA-Z_]))';
        $type = null;
        preg_match_all($pattern, $key, $keyMatch, PREG_SET_ORDER);
        if(isset($keyMatch[3])){
            $type = 'join';
        }elseif(isset($keyMatch[2])){
            $type = 'from';
        }elseif(isset($keyMatch[1])){
            $type = 'select';
        }

        return $type;
    }

    public function __destruct(){
        //print_r('[db is off]');
    }*/
}