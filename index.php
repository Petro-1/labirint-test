<?php 

class Test {

	public function __set($name, $value) 
	    {
	    	$trace = debug_backtrace();
	    	if(!isset($trace[1]) || $trace[1]['object'] != $trace[0]['object']) {
	    		try {
	    		    throw new Exception("Попытка присвоения значения readonly свойству\n\n");
	    		} catch(Exception $e) {
	    		    echo $e->getMessage();
	    		}
	    	} else {	    		
	    		$this->$name = $value;
	    	}	        
	    }

    public function __get($name) 
    {
        if (isset($this->$name)) {
            return $this->$name;
        } else {
        	try {
        	    throw new Exception("Попытка получения значения несуществующего свойства\n\n");
        	} catch(Exception $e) {
        	    echo $e->getMessage();
        	}
        }
    }

    public function __isset($name) 
    {        
        return isset($this->$name);
    }
}
/**
 * @property string $protected
 * @property string $public
 * @property string $another
 */
class Obj extends Test
{
	/**
	 * readonly свойство
	 * @var string 
	 */
    protected $protected = 'protected';

    /**
     * доступное для изменения свойство
     * @var string 
     */
    public $public = 'public';

    /**
     * еще одно доступное для изменения свойство
     * @var string 
     */
    public $another = 'another public';
}

echo "<pre>\n";

$obj = new Obj;

echo $obj->public . "\n\n";
$obj->public = 1;
echo $obj->public . "\n\n";

echo $obj->protected . "\n\n";
$obj->protected = 1;
echo $obj->protected . "\n\n";

echo $obj->another . "\n\n";
$obj->another = 1;
echo $obj->another . "\n\n";

var_dump(isset($obj->nonexist));

echo $obj->nonexist;


?>