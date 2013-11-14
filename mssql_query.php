class Query
{
  function __construct($tsql,$cols=null,$conf=null)
  {  
    $this->tsql=$tsql;
    $this->conf=$conf;  
    $this->conn=Connection::GetOne(); 
    $this->crt_query($tsql);      
  }
  private function crt_query($tsql)
  {
    Tool::log_var($tsql);
    $this->stmt = sqlsrv_query( $this->conn, $tsql, array(), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));
    if($this->stmt == null)	{
       echo "Error in query preparation 1/execution. <br>".$tsql.'<br>';
       die( Tool::log_arr( sqlsrv_errors(), true));
    } else {
     Tool::log_arr($this->stmt);
    }
    
  }
  function __destruct()
  {
    if(null!=$this->stmt)sqlsrv_free_stmt( $this->stmt); 
    //echo "<br>Cursor freed. <br><br>";
  }  
  
  function total()
  {
    echo 'Total rows:',$this->num_rows(); 
  }
  
  function print_r()
  {
    $this->total();   
    while($row=$this->get_row())
    {
      Tool::log_arr($row);
    }
  }

  function has_data()
  {
    return sqlsrv_has_rows($this->stmt );  
  }
  function num_rows()
  {
    return sqlsrv_num_rows($this->stmt );  
  }
  function get_row()
  {
    return sqlsrv_fetch_array($this->stmt, SQLSRV_FETCH_BOTH);
  }  
}  
