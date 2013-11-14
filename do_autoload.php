
ini_set('display_errors', 'on');
//session_start();
function __autoload($classname)
{
  require_once "$classname.class.php";
}
function require_class($klasses)
{
  foreach($klasses as $klass)
  {
    require_once "$klass.class.php";
  }
}
function redefine($constant,$value)
{  // avoid redefine constant
  if(!defined($constant)){
    define('MENUFILE',$value);
  }
}
$klasses=array('WSmarty','Tool','Query','Menu');
require_class($klasses);
