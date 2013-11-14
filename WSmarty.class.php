<?php
// Define our template directories
define('WWW_DIR',"C:/wamp64/www");
define('SMARTY_DIR', WWW_DIR.'/include/Smarty/libs/');

define('TEMPLATE_DIR',WWW_DIR.'/templates');
define('COMPILE_DIR', WWW_DIR.'/templates/templates_c');
define('CONFIG_DIR',  WWW_DIR.'/templates/configs');
define('CACHE_DIR',   WWW_DIR.'/templates/cache');
// Create a wrapper class extended from Smarty
require_once(SMARTY_DIR . 'Smarty.class.php');
class WSmarty extends Smarty 
{
  // $cache and $cache_lifetime are the two main variables
  // that control caching within Smarty
  private $tpl;
  static $MENU_ARRAY=null;
  static function ZSaveMenuFile($data,$menu_file=MENUFILE)
  {
    file_put_contents($menu_file, $data);
  }
  static function ZReadMenuFile($menu_file=MENUFILE)
  {
    return file_get_contents($menu_file);
  }
  static function ZFillMenuArray($menu_file=MENUFILE)
  {  
    if(!empty(self::$MENU_ARRAY))return;
    //echo file_get_contents($menu_file);
    self::$MENU_ARRAY = array();
    $one_menu=null;
    $sub_menu=null;
    foreach (file($menu_file) as $line)
    {
        if(strpos($line,',')){
          list($key, $value) = explode(',', $line,2);
          $sub_menu[]=array('menu'=>$key,'href'=>$value);      
        } else{ // one column
          $key=$line;$value=null;          
          if($key[0]==';') {// end of one menu
            $one_menu['submenu']=$sub_menu;  
            self::$MENU_ARRAY[]=$one_menu;      
            unset($sub_menu); 
            unset($one_menu);         
          } else { // begin of menu
            $one_menu=array('top'=>$key);
            $sub_menu=array();             
          }
        }
    }
    echo "<pre>";
    echo "</pre>";    
  }
  function __construct($template=null,$cache = false, $cache_lifetime = 300)
  {
    parent::__construct();
    // Change the default template directories
    $this->template_dir = TEMPLATE_DIR;
    $this->compile_dir = COMPILE_DIR;
    $this->config_dir = CONFIG_DIR;
    $this->cache_dir = CACHE_DIR;
    // Change default caching behavior
    $this->caching = $cache;
    $this->cache_lifetime = $cache_lifetime;
    if(is_null($template)){
    //__FILE__ is not correct here
      $this->tpl=sprintf("%s.tpl",basename($_SERVER['PHP_SELF'],'.php'));
    } else {
      $this->tpl=$template;
    }
    //self::FillMenuArray();
  }
  function show()
  {
    //$this->assign('menus_array',self::$MENU_ARRAY);
    $this->assign('test','My test');
    $this->assign('menu', Menu::MenuFromFile());
    parent::display($this->tpl); 
  }
 
  function set($var,$value)
  {
    $this->assign($var,$value);
  }
}
