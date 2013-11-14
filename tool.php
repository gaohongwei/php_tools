  class Tool{
    static function add_tr_css()
    {
       $css='<style type="text/css">'.
        'tr:nth-child(odd) { background-color:#3CF; }'.
        'tr:nth-child(even) { background-color:gray; }'.      
      '</style>';
      return $css;
    }  
    
    static function is_assoc($array) {
      return (bool)count(array_filter(array_keys($array), 'is_string'));
    }
    static function join_conds($limits,$sep,$prefix=null)
    {
      foreach($limits as $k=>$v){
        if(!is_numeric($k)){
          $limits[$k]=$k.'='.$v;
        }     
      }
      $limits=array_values($limits);

      $conds=implode($sep,$limits);
      if(empty($prefix)||empty($conds)) return $conds;
      return $prefix.$conds;    
    } 
    static function join_conds_v1($limits,$sep,$prefix=null)
    {
      if(self::is_assoc($limits))
      {
        $limits=array_filter($limits);
        array_walk($limits, function(&$v,$k){ $v= $k.'='.$v;});
        $limits=array_values($limits);
      }
      $conds=implode($sep,$limits);
      if(empty($prefix)||empty($conds)) return $conds;
      return $prefix.$conds;    
    }      
    static function log_var($v,$title='')
    {
      echo $v,$title,'<br>';
    }
    static function log_arr($v,$title='')
    {
      echo "<pre> $title";
      print_r($v);
      echo "</pre>";  
    }
  }
