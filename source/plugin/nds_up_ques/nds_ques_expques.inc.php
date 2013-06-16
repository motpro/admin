<?PHP
/*  nds_up_ques  v3.1
 *  Plugin FOR Discuz! X 
 *	WWW.NWDS.CN | NDS.西域数码工作室 
 *  Plugin update 20121212 BY singcee
 */
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
 set_time_limit(0);
			if(function_exists(ini_set)){
				ini_set('memory_limit','256M');
			}
define('FOOTERDISABLED',1);
      $questopic = DB::fetch_first("SELECT * FROM ".DB::table('ques_topic')." WHERE`topicid`='$topicid' LIMIT 1");
    if ($questopic['authorid'] != $_G['uid'] && $_G['adminid'] != 1 && $_G['adminid'] != 2){
    		showmessage('nds_up_ques:noopa');
    }
 if (!$hook){    
      $ndsdetail = $questopic['subject'];
	  $ndsdetail .= "\n";
	  $ndsdetail .=  str_replace(",","，",$questopic['message']);
	  $ndsdetail .= "\n";
	  $keys = '';
      $magiccount =  DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('ques_user')." WHERE `topicid`='$topicid'"), 0);
      $ndsdetail .= lang('plugin/nds_up_ques', 'datas').$magiccount.lang('plugin/nds_up_ques', 'datas1');
      $ndsdetail .= "\n";
       
      $query1 = DB::query(" SELECT * FROM ".DB::table('ques_option')." WHERE `topicid`='$topicid'  ORDER by `order`");
         $nid = 1;
     	 $tm = array('uid','user_name');
     	 $xx =  array('','');
         $qselect = $questopic['ndsabc']? array('A. ', 'B. ','C. ','D. ','E. ', 'F. ','G. ','H. ','I. ', 'J. ','K. ','L. ','M. ', 'N. ','O. ','P. ','Q. ', 'R. ','S. ','T. ','U. ', 'V. ','W. ','X. ','Y. ', 'Z. '):array();
         WHILE($quesoption = DB::fetch($query1)){	
            $tm[] = $nid.'.'.str_replace(",","，",$quesoption['title']) ;
            $xxid = 0; 
         	if (!in_array($quesoption['type'],array(6,7,8) )){
         		  	$option = explode("\n",$quesoption['option']); 
		          	foreach($option as  $varoption){
		          		 $xx[] = $qselect[$xxid].str_replace(",","，",trim($varoption));
		          		 if ($xxid) $tm[] = '';
		          		 $useroption[$quesoption['oid']][$xxid]= trim($varoption);
		          		 $optiontype[$quesoption['oid']] = $quesoption['type'];
		           	     $xxid++;
		          	}
		           if($quesoption['othinput']== 2 || $quesoption['othinput']== 3){
		           	  $tm[] = '';
		           	  $othinput[$quesoption['oid']] = $quesoption['othinput'];
		           	  $xx[] = str_replace(",","，",trim($varoption));	
		           } 
		          	
         	}else{
         		 $useroption[$quesoption['oid']][0]= 'NUL';
         		 $xx[] = 'NUL';
         		 $optiontype[$quesoption['oid']] = $quesoption['type']; 
         	}
            $nid++;	
       	 } 
       $ndsdetail .= implode(',',$tm); 
       $ndsdetail .= "\n"; 
       $ndsdetail .= implode(',',$xx);
       $ndsdetail .= "\n"; 
       $query2 = DB::query(" SELECT * FROM ".DB::table('ques_user')." WHERE `topicid`='$topicid' ORDER by $orderby dateline ");
       while($quesuser = DB::fetch($query2)){
       	 $user = array();	
		 $user[] =  $quesuser['authorid'];
	     $user[] =  $quesuser['author'];
	    foreach($useroption as $key => $vararr){
        $answer = DB::fetch_first(" SELECT answer,othinput FROM ".DB::table('ques_result')." WHERE `oid`='$key' AND `qid`='$quesuser[qid]'");
		 $uidanswer = explode(",", $answer['answer']);
	  if (!in_array($optiontype[$key],array(6,7,8) )){	 
	     foreach($vararr as $key2 => $varop){
	     	$varop =trim($varop);
	     	$nwdscn = 0;
	       foreach($uidanswer as  $varanswer){
	       	$varanswer = trim($varanswer);
	       	 if ($varop == $varanswer ){
	       	 	$user[] = '1';
	       	 	$nwdscn = 1;
	       	 }
	      }
	        if (!$nwdscn){
	          $user[] = '';	
	        }
       }
               if($othinput[$key]== 2 || $othinput[$key] == 3){
                   $user[] = str_replace(",","，",$answer['othinput']);	
		           } 
       
    	}else {
    		$user[] = str_replace(",","，",$uidanswer[0]);
    	}
	   }
	   $ndsdetail .= implode(',',$user);
       $ndsdetail .= "\n";
    } 
    $filename = 'ndsques'.$topicid.'_'.date('Ymd', TIMESTAMP).'.csv';       	
    
    
   }else{    
    
    function makereport($oid,$title,$option,$type,$chmin,$chmax,$ndssum,$data = array(),$keyarray = '',$total = 0,$nid,$ndsabc){
   	$qselect = array('A. ', 'B. ','C. ','D. ','E. ', 'F. ','G. ','H. ','I. ', 'J. ','K. ','L. ','M. ', 'N. ','O. ','P. ','Q. ', 'R. ','S. ','T. ','U. ', 'V. ','W. ','X. ','Y. ', 'Z. ');
	$list= '';
	$i= 1;
	$b = 0;
	$c = 0;
	$total = $total ? $total:0;
	$optionarr = explode("\n",$option);
	$optlen = count($optionarr);
	$title = str_replace(",","，",$title);
	if ($optlen > 25 || !$ndsabc ) $qselect = array();
	if ($type!=8){ 
	     foreach(explode("\n",$keyarray) as $t){
	    	 $t = trim($t);
	    	 $t= str_replace(",","，",$t);
	    	 $pc = $total ? intval($data[$t]*100 / $total) : 0;
	         $pp .= ','.$qselect[$b++].$t.','.($data[$t] ? $data[$t] : 0).','.$pc.'%'."\n";
        }
	 }else{// 滑动块统计结果
	 	$pc  = $ndssum/$total/($chmax-$chmin+1)*100;
	 	$pp .= ',min:'.$chmin.'-- max:'.$chmax.','.$ndssum/$total.','.$pc.'%'."\n";
    
	 }
	   $list= $nid.'.'.$title.', ,'.$total."\n".$pp;
	return $list;
}
    $ndsdetail = $questopic['subject'];
	  $ndsdetail .= "\n";
	  $ndsdetail .=  str_replace(",","，",$questopic['message']);
	  $ndsdetail .= "\n";
      $magiccount =  DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('ques_user')." WHERE `topicid`='$topicid'"), 0);
      $ndsdetail .= lang('plugin/nds_up_ques', 'datas').$magiccount.lang('plugin/nds_up_ques', 'datas1');
      $ndsdetail .= "\n";   	    
			 	 $query3 = DB::query(" SELECT * FROM ".DB::table('ques_result')." WHERE `topicid`='$topicid' ORDER BY `oid`");
			     $uu = $cc =$tt =array(); 
			 	 WHILE($quesoptions = DB::fetch($query3)){		
			     	  if($quesoptions['answer']){
			     	    Foreach(explode(",",$quesoptions['answer']) as $vles){
			     	    	$vles = trim($vles);
			     	    	$uu[$quesoptions['oid']][$vles] = $vles;
			     	    	$cc[$quesoptions['oid']][$vles]++; 	
			     	    	$tt[$quesoptions['oid']]++;
			     	    }
			     	  }
			     }
			     
		 $ndsdetail .= 'Title,Option,Total/Avg,Proportion%';
		 $ndsdetail .= "\n";
		       
			$query2 = DB::query(" SELECT * FROM ".DB::table('ques_option')." WHERE `topicid`='$topicid' AND `type` NOT IN (6,7) ORDER by `order`");
            $nid = 1;
 			WHILE($quesoption = DB::fetch($query2)){
//               $ndsdetail .= $nid.'.'.str_replace(",","，",$quesoption['title'])."\n" ;
 				$k = array();$total = 0; $ndssum = 0;
    		     if(is_array($uu[$quesoption['oid']])){
			        foreach($uu[$quesoption['oid']] as $dis => $kles){
			      	    if ($quesoption['type'] == 8){
			      	      	$ndssum += intval($kles);
			      	    }else{
			        	$dis = $dis;
			        	$k[$dis] = $cc[$quesoption['oid']][$dis];
			      	    }
			        }
			       
			      }			      
			     $total = $tt[$quesoption['oid']];
											
				$ndsdetail .= makereport($quesoption['oid'],$quesoption['title'],$quesoption['option'],$quesoption['type'],$quesoption['chmin'],$quesoption['chmax'],$ndssum,$k,$quesoption['option'],$total,$nid++,$questopic['ndsabc']);
			}		     
      
   $filename = 'ndsstats'.$topicid.'_'.date('Ymd', TIMESTAMP).'.csv'; 
  //!stats  
 } 
    header("Content-type: application/vnd.ms-execl");
	header('Content-Encoding: none');
	header('Content-Disposition: attachment; filename='.$filename);
    header("Pragma: no-cache");
	header('Expires: 0');
	if($_G['charset'] != 'gbk') {
		$ndsdetail = diconv($ndsdetail, $_G['charset'], 'GBK');
	}
	echo $ndsdetail;
	exit();
			
	
?>