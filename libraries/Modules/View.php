<?php
class View{
    function __construct($name,$type="php"){
        $this->set_filename($name,$type);
        return $this;
    }
    
    public function set_filename($name,$type){
        $this->tsf_filename = $name;
        $this->tsf_filetype = $type;
    }
    
    public function set($a,$b=''){
        if (is_array($a))
        {
            foreach ($a as $key => $value)
            {
                    $this->{$key} = $value;
            }
        }
        else
        {
                $this->{$a}=$b;
        }
        
		return $this;
	}
    
    public function get($a){
        return $this->{$a};
    }
    
    public function get_html(){
        
    }
}
?>