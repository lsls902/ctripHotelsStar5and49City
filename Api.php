<?php
error_reporting(0);
class Api extends CI_Controller {
    public function __construct() {
        parent::__construct(); 
    }
    
    /**
     * get hotel some data :content ,refixtime ,starttime balabala
     */
    
    
  public function mget4(){

       $list= $this->db->where("data3","")->limit(10)->get("src")->result_array();
       
       if(count($list)>0){
               foreach($list as $k=>$v)
                    {
                    $filename="http://hotels.ctrip.com/hotel/".$v["hid"].".html?isFull=T#ctm_ref=hod_sr_lst_dl_n_1_1";
                     $file= file_get_contents($filename);
                        $mm=str_replace("\"","",$file);
                        $mm=str_replace(">","",$mm);
                        $mm=str_replace("<","",$mm); 
                     $arr=explode('酒店介绍',$mm);
                     $arr2=explode('显示全部',$arr[1]);
                     
                      $this->db->where("id",$v["id"])->update("src",array("data3"=>$arr2[0]));
                     
                 }
                   echo "<script>location.href='http://localhost/index.php/Api/mget4?rand=".rand(0,99999)."'</script>";
       }
       else
           exit("over");
     }
    
     /**
      * get comment new top 10.
      */
     
     public function mget3(){

       $data = $this->db->where("data2","")->get("src")->row_array();

       if($data["hid"]){
         $filename="http://m.ctrip.com/webapp/hotel/hoteldetail/dianping/".$data["hid"].".html?&fr=detail&atime=20190313&days=1";
         $file= file_get_contents($filename);
            $mm=str_replace("\"","",$file);
            $mm=str_replace(">","",$mm);
            $mm=str_replace("<","",$mm); 
         $arr=explode('__COMMON_DATA',$mm);
         $this->db->where("id",$data["id"])->update("src",array("data2"=>$arr[1]));
          echo "<script>location.href='http://localhost/index.php/Api/mget3?rand=".rand(0,99999)."'</script>";

       }
       else
           exit("over");
     
     }
    
     /**
      * get  ctrip.com hotelid as hid row and price  from data row .
      * 
      *  change row75  row76,you can get hid.
      * 
      */
     
    public function mget2(){
        
//        $list = $this->db->get("src")->result_array();
//        
//        foreach($list as $k=>$v)
//        {
//            
//            $arr=explode('J_price_lowList',$v["data"]);
//            $arr2=explode('/span/',$arr[1]);
//            
//            $this->db->where("id",$v["id"])->update("src",array("price"=>$arr2[0]));
//            
//        }
        
        
        
    }


/**
 * list page start p=1 n=0
 */
 

    public function mget(){
        
        $p=$_GET["p"];//1
        $n=$_GET["n"];//0

        if($n*1>48)
        exit("over");
        
        
        
  $mycity=array("shanghai2","beijing1",
            "guangzhou32","shenzhen30","tianjin3","xi'an10",
            "chongqing4","chengdu28","dalian6","qingdao7","nanjing12",
            "suzhou14","hangzhou17","xiamen25","sanya43","jinan144","ningbo375",
            "shenyang451","wuhan477","zhengzhou559","changsha206","lijiang37","haikou42","nanchang376","fuzhou258",
            "guilin33","guiyang38","changchun158","shijiazhuang428","taiyuan105","hohhot103","harbin5","nanning380",
            "lanzhou100","kunming34","lhasa41","xining124","urumqi39",
            "yinchuan99","hong%20kong58","macau59","wuxi13","dali6","wenzhou491","nantong82","yangzhou15",
      "luoyang350","weihai479","yantai533"
            );

  
            $city=$mycity[$n];
  
       
//        
            $filename="http://hotels.ctrip.com/hotel/".$city."/star5p".$p;
            $file= file($filename);

            $mm=str_replace("","",$file[770]);
            $mm=str_replace("\"","",$mm);
            $mm=str_replace(">","",$mm);
            $mm=str_replace("<","",$mm); 
            
            $arr=explode('查看相册',$mm);

            foreach ($arr as $k=>$v){
          //    $this->db->insert("src", array("data"=>$v,"city"=>$city,"p"=>$p,"n"=>$n));
            }
           
  
          $p=$p*1+1;
          
          
          if($p>10){
          $p=1;
          $n=$n*1+1;
          }

         // echo "<script>location.href='http://localhost/index.php/Api/mget?p=".$p."&n=".$n."'</script>";

    }
}

?>