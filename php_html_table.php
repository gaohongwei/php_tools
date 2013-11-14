class HtmlTable
{
  function __construct($cols)
  {  // array_column
    if(array_keys($cols) ==  range(0,count($cols)-1))
    {  // simple array
      $this->cols=$cols;   
      $this->heads=$cols;    
    } else {
      $this->cols=array_keys($cols);   
      $this->heads=array_values($cols);       
    }
    $this->cols=$cols;
    if(isset($heads)){
     $this->heads=$heads;
    } else {
     $this->heads=$cols; 
    }    
  }
  function print_head()
  {
    echo "<table border='1'><tr>";
    foreach($this->heads as $head)
    {
      echo "<th>",$head,"</th>";
    }       
    echo "</tr>";  
  }
  function print_tail()
  {
    echo "</table>";    
  }
  function print_td($data)
  {
    echo "<td>",$data,"</td>";   
  }
  function print_row($row)
  {
    echo $this->get_row($row);
  }
  function get_row($row)
  {
    $cols=$this->cols;
    $href_index=array_keys($this->hrefs);
    if(count($cols) < 1 ) return;
    $html = '<tr>';   
    for($indx=0;$indx<count($cols);$indx++)
    {
      $col=$cols[$indx];
      if( 0 == $indx )
      {
        if ( $this->check_box ){
          $col=$cols[$indx];
          $html .="<td align='center'><input type='checkbox' value='$row[$col]' name='$this->check_box_name' ></td>";  
        }else {
          $html .= '<td>'.$row[$col].'</td>';              
        }
      }
      else if( in_array($indx,$href_index))
      {
        $href=$this->hrefs[$indx];  
        $fmt=$href['fmt'];
        $val=$row[$href['col']];
        $href=sprintf($fmt,$val);
      
        $html .= "<td><a href=$href>$row[$col]</td>";            
      } else {
        $html .= '<td>'.$row[$col].'</td>';                
      }
    }       
    $html .='</tr>'; 
    return $html;
  }  
  protected $check_box_name='box[]';
  protected $check_box=false;   
  protected $hrefs=array();  
  function setCheckBox($cbox_name='cbox[]')
  {
    $this->check_box=true;
  }

  function setHref($col_index=0,$href)
  {
    $this->hrefs[$col_index]=$href;
  }

  function __call($method,$args)
  { 
    if (strlen($method) < 4) return;
    
    $fname=substr($method,0,3);
    $prop=substr($method,3);
    if($fname == 'set') {
      $this->$prop=$args;
    
    } else  {
      // only support set now    
    }
  }
}
