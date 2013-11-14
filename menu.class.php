<?php
define('MENUFILE','menu.cfg');
define('SUBMENU','submenu');
define('TOPMENU','topmenu');

//array_merge($array1, $array2);
class Menu
{
  private $menu_array=null;    
  private static $_singleton=null;
  private static $MENU_ARRAY=null;
  private static $MENU_ADM=array(
  TOPMENU=>'Menu Adm',
  SUBMENU=>array(
              array('menu'=>'Edit','href'=>'edit_menu.php'),
              array('menu'=>'Show','href'=>'show_menu.php')
              )); 
  private static $fname=MENUFILE;
  static $SAMPLE=<<<HERE
    # There is no menu configuration file in the system yet.
    # This is a sample menu configuration file
    # Each menu starts with a top menu which is string in one columm 
    # Each menu ends with a semi-comma in a seperate line
    # Each menu has many sub-menu follwing it 
    # Each sub-menu has a menu name and its href link.
    # One level menu is supported
Index,index.php
;
TopMenu2
submenu21,herf21
submenu22,herf22
submenu23,herf23
;
TopMenu3
submenu31,herf31
submenu32,herf32
submenu33,herf33
;
Google, http://www.google.com
;
HERE;

  private function __construct($menu_array)
  {  
    $this->menu_array=$menu_array;
    //echo "Create Menu again";
  }
  private function crt_one_menu($menu,$href)
  {
    return "<li><a href=$href>$menu</a></li>";  
  }
  private function crt_one_link($menu,$href)
  {
    return "<li class='nav nav-pills'><a href='$href'>$menu</a></li>";
  } 
  
  private function get_menu()
  {
    $menus_array=$this->menu_array;
    if(empty($menus_array))return false;
    $html='<ul class="nav nav-pills">'; 
    foreach($menus_array as $menu){
      if(array_key_exists(TOPMENU,$menu) && !empty($menu[TOPMENU])){
        $html .='<li class="dropdown" id="menu1" >';
        $html .="<a class='dropdown-toggle' data-toggle='dropdown' href=\"{$menu[TOPMENU]}\">";
        $html .=$menu[TOPMENU];
        $html .='<b class="caret"></b>';
        $html .='</a>';
        $html .='<ul class="dropdown-menu">';
        foreach($menu[SUBMENU] as $sub_menu){
            $html .=$this->crt_one_menu($sub_menu['menu'],$sub_menu['href']);   
        }
        $html .='</ul>';
        $html .='</li>';
      } else {
        foreach($menu[SUBMENU] as $sub_menu){
            $html .=$this->crt_one_link($sub_menu['menu'],$sub_menu['href']);   
        }      
      }
    }
    $html .='</ul>';  
    return $html;
  }

  static function SaveMenuFile($data,$menu_file=MENUFILE)
  {
    file_put_contents($menu_file, $data);
  }
  static function ReadMenuFile($menu_file=MENUFILE)
  {
    $content=null;
    if(file_exists($menu_file)){
      $content=file_get_contents($menu_file);
    }
    if(empty($content)){
      return self::$SAMPLE;
    } else{
    return $content;
    }
  }
  
  static function MenuFromFile($is_adm=true,$menu_file=MENUFILE)
  {  
    $menu_array=self::GetMenuArrayFromFile($menu_file);
    if($is_adm)
    {
      $menu_array[]=self::$MENU_ADM;       
    }   
// && (self::$_singleton instanceof self)
    if(!isset(self::$_singleton))
    {
      self::$_singleton=new Menu($menu_array);  
    }    
    return self::$_singleton->get_menu();
  }
 private static function GetMenuArrayFromFile($menu_file=MENUFILE)
  {  
    $menu_array = array();
    if(!file_exists($menu_file)){
      self::SaveMenuFile(self::ReadMenuFile($menu_file),$menu_file);
    }
    
    $one_menu=null;
    $sub_menu=null;
    $is_new=true;
    $line=null;
    foreach (file($menu_file) as $line)
    {
      $line=trim($line,"\n\t\r\ \0\x0B");
      if(empty($line)) continue;
      if($line[0]=='#') continue;

      if($is_new){ // Create one new menu
        $one_menu=array();
        $sub_menu=array();        
      }
      if($line[0] == ';'){  // end a menu
        $one_menu[SUBMENU]=$sub_menu;  
        $menu_array[]=$one_menu;          
        unset($sub_menu); 
        unset($one_menu); 
        $is_new=true;  
        continue;
      } else {
        $is_new=false;
      }
      if(strpos($line,',')){
        list($key, $value) = explode(',', $line,2);
        $sub_menu[]=array('menu'=>$key,'href'=>$value);    
      }
      else {
        $key=$line;$value=null;   
        $one_menu=array(TOPMENU=>$key);  
      }        
    } 
  return $menu_array;    
  }
}
?>
