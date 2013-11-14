class Connection
  {
    private static $connected=null;
    private $conn;
    
    static function GetOne()
    {
      if(self::$connected==null)
      {
        self::$connected=new Connection();
      }
      return self::$connected->conn;     
    }  

    static function GetOneTest()
    {
      if(self::$connected==null)
      {
        self::$connected=new Connection('cursa','tester','tester');
      }
      return self::$connected->conn;     
    }      
    private function __construct($serverName=null,$uid=null,$pwd=null)
    {
      $connectionInfo=null;
      $serverName =is_null($serverName)? $_SESSION['MSSQL_SERVER2']:$serverName;
      if(is_null($pwd)||is_null($uid))
      {
        $connectionInfo = array('ReturnDatesAsStrings'=>true);  
      } else {
        $connectionInfo = array('ReturnDatesAsStrings'=>true,'UID'=>$uid,'PWD'=>$pwd);        
      }
      $this->conn = sqlsrv_connect( $serverName, $connectionInfo);
      if( $this->conn === false ) {
         print_r($connectionInfo);
         //throw new Exception('Cannot connect');
         die( print_r( sqlsrv_errors(), true));
      }    
    }
    function __destruct()
    {
      if(null!=$this->conn)
      {
        sqlsrv_close( $this->conn);
        $this->conn=null;
      }
    }
  }
