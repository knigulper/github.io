class PR {
 
 
  
 
 
  #google toolbar url
 
 
  private $base;
 
 
  
 
 
  #holds current page rank
 
 
  public $rank;
 
 
  
 
 
  function __construct($url){
 
 
    $this->rank=false;
 
 
    $this->base="http://toolbarqueries.google.com/tbr?client=navclient-auto&ch=";
 
 
    $this->get_google_pagerank($url);
 
 
  }
 
 
  
 
 
  private function get_google_pagerank($url) {
 
 
    $query=$this->base.$this->check_hash($this->hash_URL($url)). "&features=Rank&q=info:".$url."&num=100&filter=0";
 
 
    $data=file_get_contents($query);
 
 
    $pos = strpos($data, "Rank_");
 
 
    if($pos === false){}
 
 
    else{
 
 
      $pagerank = substr($data, $pos + 9);
 
 
      $this->rank=$pagerank;
 
 
    }
 
 
  }
 
 
  
 
 
  private function str_to_num($Str, $Check, $Magic){
 
 
    $Int32Unit = 4294967296; // 2^32
 
 
    $length = strlen($Str);
 
 
    for ($i = 0; $i < $length; $i++) {
 
 
      $Check *= $Magic;
 
 
      if ($Check >= $Int32Unit) {
 
 
        $Check = ($Check - $Int32Unit * (int) ($Check / $Int32Unit));
 
 
        $Check = ($Check < -2147483648) ? ($Check + $Int32Unit) : $Check;
 
 
      }
 
 
      $Check += ord($Str{$i});
 
 
    }
 
 
    return $Check;
 
 
  }
 
 
  
 
 
  private function hash_URL($String){
 
 
    $Check1 = $this->str_to_num($String, 0x1505, 0x21);
 
 
    $Check2 = $this->str_to_num($String, 0, 0x1003F);
 
 
    $Check1 >>= 2;
 
 
    $Check1 = (($Check1 >> 4) & 0x3FFFFC0 ) | ($Check1 & 0x3F);
 
 
    $Check1 = (($Check1 >> 4) & 0x3FFC00 ) | ($Check1 & 0x3FF);
 
 
    $Check1 = (($Check1 >> 4) & 0x3C000 ) | ($Check1 & 0x3FFF);
 
 
    $T1 = (((($Check1 & 0x3C0) << 4) | ($Check1 & 0x3C)) <<2 ) | ($Check2 & 0xF0F );
 
 
    $T2 = (((($Check1 & 0xFFFFC000) << 4) | ($Check1 & 0x3C00)) << 0xA) | ($Check2 & 0xF0F0000 );
 
 
    return ($T1 | $T2);
 
 
  }
 
 
  
 
 
  private function check_hash($Hashnum){
 
 
    $CheckByte = 0;
 
 
    $Flag = 0;
 
 
    $HashStr = sprintf('%u', $Hashnum) ;
 
 
    $length = strlen($HashStr);
 
 
    for ($i = $length - 1; $i >= 0; $i --) {
 
 
      $Re = $HashStr{$i};
 
 
      if (1 === ($Flag % 2)) {
 
 
        $Re += $Re;
 
 
        $Re = (int)($Re / 10) + ($Re % 10);
 
 
      }
 
 
      $CheckByte += $Re;
 
 
      $Flag ++;
 
 
    }
 
 
    $CheckByte %= 10;
 
 
    if (0 !== $CheckByte) {
 
 
      $CheckByte = 10 - $CheckByte;
 
 
      if (1 === ($Flag % 2) ) {
 
 
        if (1 === ($CheckByte % 2)) {
 
 
          $CheckByte += 9;
 
 
        }
 
 
        $CheckByte >>= 1;
 
 
      }
 
 
    }
 
 
    return '7'.$CheckByte.$HashStr;
 
 
  }
 
 
}
 
 
 
 
 
if(isset($_GET['url'])){
 
 
  $url=$_GET['url'];
 
 
  $pr = new PR($url);
 
 
 
 
 
  if($pr->rank)
 
 
    echo "This page rank:".$pr->rank;
 
 
  else
 
 
    echo "This page doesn't have any GOOGLE PR";
 
 
}
