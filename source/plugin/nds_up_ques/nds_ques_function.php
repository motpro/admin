<?PHP
/*  nds_up_ques  v3.1
 *  Plugin FOR Discuz! X 
 *	WWW.NWDS.CN | NDS.西域数码工作室 
 *  Plugin update 20121212 BY singcee
 */
 
function makeoption($oid,$title,$desp,$option,$type,$least,$chmin,$chmax,$othinput,$textsize,$textareawidth,$input = '',$disable = '',$stats = 0,$data='',$keyarray,$showright = 0,$ndsabc,$nid,$sysmode,$mark,$mymark=-1,$flag=0){
	$list= '';$i=1;$b = 1;$abc=0;
	$qselect = array('A. ', 'B. ','C. ','D. ','E. ', 'F. ','G. ','H. ','I. ', 'J. ','K. ','L. ','M. ', 'N. ','O. ','P. ','Q. ', 'R. ','S. ','T. ','U. ', 'V. ','W. ','X. ','Y. ', 'Z. ');
 	$t  = ''.$least != 0 ? lang('plugin/nds_up_ques', 'answerchoose').' ' : ('<span style="color:#009900;">'.lang('plugin/nds_up_ques','answermust').'</span> ');
	$t .= ''.$chmin && in_array($type,array(4,5,9)) ? lang('plugin/nds_up_ques', 'nds_chmins').$chmin.lang('plugin/nds_up_ques', 'nds_js_max2'):'';
	$t .= ''.$chmax && in_array($type,array(4,5,9)) ? lang('plugin/nds_up_ques', 'nds_chmaxs').$chmax.lang('plugin/nds_up_ques', 'nds_js_max2'):'';
	$boxchk1 = $showright ? 'onclick="clickTable('.$nid.');':'onclick="';
	$boxchk2 ='';
	$chmax && in_array($type,array(4,5,9)) && !$stats ? $boxchk1 .='chmax_checkbox('.$oid.','.$chmax.',this);':'' ;
	$inputtext = $othinput && in_array($type,array(2,3,4,5)) ? '<input type="text" id="otinput['.$oid.']" name="otinput['.$oid.']" disabled  value="'.$data.'" size="50" maxlength="200" >':'' ;
	if($sysmode == 2 && !empty($mark) ){
		$t .= '&nbsp;&nbsp;'.lang('plugin/nds_up_ques','maxmark').$mark.lang('plugin/nds_up_ques','mark2');
	}
   if($sysmode == 2  && $mymark >= 0   ){
		$t .= '&nbsp;&nbsp;'.lang('plugin/nds_up_ques','mymark').$mymark.lang('plugin/nds_up_ques','mark2');
	}
	$optionarr = explode("\n",$option);
	$optlen = count($optionarr);
	 $seeanswere = 0;
	if (!empty($keyarray) && $stats){
	 $iskeyarr = explode(",",$keyarray);
	 $seeanswere = 1;
	 $at1 = '<span class="ans1">';
	 $at2 = '</span>';
	}
	if ($stats){
		$flag1='';
	    $flag2='';
	}else{
		$flag1='<div id="td'.$oid.'" class="td1"><a name="tda'.$nid.'">';
		$nwdscn = $flag?'<img border="0" title="'.lang('plugin/nds_up_ques','nds_flag').'" src="./source/plugin/nds_up_ques/images/flag.gif" />':'';
	    $flag2='</a>&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)"  onclick="javascript:ndstag('.$oid.')">'.$nwdscn.'</a></div>';
	}
	if ($optlen > 25 || !$ndsabc ) $qselect = array();
	switch ($type) {	
	  case  1 : 
		  $j= lang('plugin/nds_up_ques','sstype');
		   $stats ? $boxchk = '':$boxchk = $boxchk1.'"'; 
		  $k = '<select name="suboption['.$oid.']" '.$disable.' '.$boxchk.'  >';
	     if( $seeanswere && !empty($iskeyarr[0])) {
	        $a1 = $at1;
	        $a2 = $at2;
	     	$a3 = '&nbsp;&nbsp;'.lang('plugin/nds_up_ques','nds_correct').'&nbsp;'.$a1.$iskeyarr[0].$a2;
	     }
		  foreach(explode("\n",$option) as $value){
		  $value = trim($value);
		 // $iskey = trim($iskeyarr[0]);
		  if(!empty($value)){ 
	 		$k .= '<option value="'.$value.'" '.(trim($input) == $value ? 'selected' : '').'>'.$qselect[$abc].''.$value.'</option>';
			$abc++;
		  } 
		 }
		  $k .= '</select>';

		$list= '<tr class="fl_row"><td>'.$flag1.'<h2>'.$nid.'.&nbsp;'.$title.'</h2>&nbsp;<span class="notes">['.$j.''.$t.']</span>'.$flag2.'<div class="postmessage">'.$desp.'</div>'.$k.$a3.'</td></tr>';
		break;
	case  2 : 
		  $j= lang('plugin/nds_up_ques','sstype');
		  $k = '';
		foreach($optionarr as  $value){
			$value = trim($value);
		 if(!empty($value)){
		    $a1 = '';
	        $a2 = '';
	    	$iskey = trim($iskeyarr[0]);
		 if ($seeanswere && !empty($iskey) && $value == $iskey ) {
		 	 $a1 = $at1;
	         $a2 = $at2;
		 	}
		    $opinputtext = ''; 
		    $boxchk2 = ($othinput == 2 || $othinput == 3)? 'pt_radiocl('.$oid.');':'';
		      if(($othinput == 2 || $othinput == 3 )&&($i == $optlen)) {
               $opinputtext = $inputtext ;
               $boxchk2 = 'pt_radio('.$oid.');';
             }
            $stats ? $boxchk = '':$boxchk = $boxchk1.$boxchk2.'"'; 
			$k .= '<input type="radio" name="suboption['.$oid.']" value="'.$value.'" '.$disable.' '.(trim($input) == $value ? 'checked' : '').' '.$boxchk.'>'.$qselect[$abc].''.$a1.$value.$a2.' '.$opinputtext.'&nbsp;&nbsp;';
		    $abc++;
		    $i++;
		 }
		} 
		$list= '<tr class="fl_row"><td>'.$flag1.'<h2>'.$nid.'.&nbsp;'.$title.'</h2>&nbsp;<span class="notes">['.$j.''.$t.']</span>'.$flag2.'<div class="postmessage">'.$desp.'</div>'.$k.'</td></tr>';		
		break;
	case  3 : 
		          $j= lang('plugin/nds_up_ques','sstype');
				  $k = '';

		foreach($optionarr as $value){
			$value = trim($value);
		  if(!empty($value)){
		    $a1 = '';
	        $a2 = '';
	    	$iskey = trim($iskeyarr[0]);
		   if ($seeanswere && !empty($iskey) && $value == $iskey ) {
		 	 $a1 = $at1;
	         $a2 = $at2;
		 	}
		    $opinputtext = ''; 
            $boxchk2 = ($othinput == 2 || $othinput == 3 )? 'pt_radiocl('.$oid.');':'';		    
		      if(($othinput == 2 || $othinput == 3 )&&($i == $optlen)) {
               $opinputtext = $inputtext ;
               $boxchk2 = 'pt_radio('.$oid.');';
             }
            $stats ? $boxchk = '':$boxchk = $boxchk1.$boxchk2.'"';
			$k .= '<input type="radio" name="suboption['.$oid.']" value="'.$value.'" '.$disable.' '.(trim($input) == $value ? 'checked' : '').' '.$boxchk.'>'.$qselect[$abc].' '.$a1.$value.$a2.' '.$opinputtext.'<br />';
		    $abc++;
		    $i++;
		  }
		}	
		$list= '<tr class="fl_row"><td>'.$flag1.'<h2>'.$nid.'.&nbsp;'.$title.'</h2>&nbsp;<span class="notes">['.$j.''.$t.']</span>'.$flag2.'<div class="postmessage">'.$desp.'</div>'.$k.$pp.'</td></tr>';	
		break;
	case  4 : 
	      $j = lang('plugin/nds_up_ques','mmtype');
		  $k = '';
		foreach($optionarr as $value){
			$value = trim($value);
		 if(!empty($value)){
		 	$a1 = '';
	        $a2 = '';
			$inputarr = explode(",",$input);
			foreach($inputarr as $key => $inputs){
			 $inputarr[$key] = trim($inputs);	
			}
			if ($seeanswere){
			 foreach($iskeyarr as  $iskey){
			 	$iskey = trim($iskey);
			 	if (!empty($iskey) && $value == $iskey ) {
		 	  	    $a1 = $at1;
	          		$a2 = $at2;
		 	  	}		
			 }
			}
             if(($othinput ==1 || $othinput == 3 )&&($i == $optlen) && !$stats  ) {
               $boxchk2 = 'pt_checkbox('.$oid.',this,'.$othinput.');';
             }
            $opinputtext = ''; 
		   if(($othinput == 2 || $othinput == 3 )&&($i == $optlen) ) {
	            $opinputtext = $inputtext ;
	            $boxchk2 = 'pt_checkbox('.$oid.',this,'.$othinput.');';
             }
            $stats ? $boxchk = '':$boxchk = $boxchk1.$boxchk2.'"';  
    		$k .= '<input type="checkbox" name="suboption['.$oid.']['.$i.']" value="'.$value.'" '.$disable.' '.(in_array($value,$inputarr) ? 'checked' : '').' '.$boxchk.'>'.$qselect[$abc].' '.$a1.$value.$a2.' '.$opinputtext.'&nbsp;&nbsp;';
			$abc++;
			$i++;
	   	}
	   }
		
		$list= '<tr class="fl_row"><td>'.$flag1.'<h2>'.$nid.'.&nbsp;'.$title.'</h2>&nbsp;<span class="notes">['.$j.''.$t.']</span>'.$flag2.'<div class="postmessage">'.$desp.'</div>'.$k.$pp.'</td></tr>';			
		break;
	case  5 : 
	      $j = lang('plugin/nds_up_ques','mmtype');
		  $k = '';
		foreach($optionarr as $value){
			$value = trim($value);
		  if(!empty($value)){
		 	$a1 = '';
	        $a2 = ''; 	
			$inputarr = explode(",",$input);
			foreach($inputarr as $key => $inputs){
			 $inputarr[$key] = trim($inputs);	
			}
		   if ($seeanswere){
			 foreach($iskeyarr as  $iskey){
			 	$iskey = trim($iskey);
			 	if (!empty($iskey) && $value == $iskey ) {
		 	  	    $a1 = $at1;
	          		$a2 = $at2;
		 	  	}		
			 }
			}
             if(($othinput ==1 || $othinput == 3 )&&($i == $optlen) && !$stats  ) {
               $boxchk2 = 'pt_checkbox('.$oid.',this,'.$othinput.');';
             }
            $opinputtext = ''; 
		   if(($othinput == 2 || $othinput == 3 )&&($i == $optlen) ) {
               $opinputtext = $inputtext ;
              $boxchk2 = 'pt_checkbox('.$oid.',this,'.$othinput.');';
             }
			    $stats ? $boxchk = '':$boxchk = $boxchk1.$boxchk2.'"'; 
             $k .= '<input type="checkbox" name="suboption['.$oid.']['.$i.']" value="'.$value.'" '.$disable.' '.(in_array($value,$inputarr) ? 'checked' : '').' '.$boxchk.'>'.$qselect[$abc].' '.$a1.$value.$a2.' '.$opinputtext.'<br />';
			$abc++;
			$i++;
		 }
		}
		$list= '<tr class="fl_row"><td>'.$flag1.'<h2>'.$nid.'.&nbsp;'.$title.'</h2>&nbsp;<span class="notes">['.$j.''.$t.']</span>'.$flag2.'<div class="postmessage">'.$desp.'</div>'.$k.$pp.'</td></tr>';			
		break;
	case  6 : 
		$j = lang('plugin/nds_up_ques','tktype');
		if (!empty($keyarray) && $stats ){
	      $iskeyarr = explode("\n",$keyarray);
	      $a3 = '&nbsp;&nbsp;'.lang('plugin/nds_up_ques','nds_correct').'&nbsp;';
		      foreach($iskeyarr as  $iskey){
			    	$iskey = trim($iskey);
				    if(!empty($iskeyarr[0])) {
				        $a1 = $at1;
				        $a2 = $at2;
				     	$a3 .= $a1.$iskey.$a2.'&nbsp;&nbsp;&nbsp;&nbsp;';
				     }
		      }
		}
		  $stats ? $boxchk = '':$boxchk = $boxchk1.'"'; 
		$list= '<tr class="fl_row"><td>'.$flag1.'<h2>'.$nid.'.&nbsp;'.$title.'</h2>&nbsp;'.($othinput == 52 ? '<input type="text" name="suboption['.$oid.']" size="'.$textsize.'" '.$disable.' value="'.$input.'" '.$boxchk.' >'.$a3.'&nbsp;':'').'<span class="notes">['.$j.''.$t.']</span>'.$flag2.'<div class="postmessage">'.$desp.'</div>'.($othinput == 52?'':'<input type="text" name="suboption['.$oid.']" size="'.$textsize.'" '.$disable.' value="'.$input.'" '.$boxchk.' >'.$a3).'</td></tr>';					
	  break; 
	case  7 : 
		$j = lang('plugin/nds_up_ques','jdtype');
		 $stats ? $boxchk = '':$boxchk = $boxchk1.'"';  
		$list= '<tr class="fl_row"><td>'.$flag1.'<h2>'.$nid.'.&nbsp;'.$title.'</h2>&nbsp;<span class="notes">['.$j.''.$t.']</span>'.$flag2.'<div class="postmessage">'.$desp.'</div>'.($input ? '<blockquote style="margin-left:8px; margin-right:8px; border:#000080 dashed 1px; background-color:#FFFFFF;"><div class="postmessage">'.discuzcode($input,0,0).'</div></blockquote>' : '<textarea name="suboption['.$oid.']" rows="'.$textareawidth.'" cols="'.$textsize.'" '.$disable.' '.$boxchk.'>'.$input.'</textarea>').'</td></tr>';			
	  break;
	case  8 : 
	     $stats ? $boxchk = '':$boxchk = $boxchk1.'"'; 
		$j = lang('plugin/nds_up_ques','hdtype');
	    $list= '<tr class="fl_row"><td width="600px">'.$flag1.'<h2>'.$nid.'.&nbsp;'.$title.'</h2>&nbsp;<span class="notes">['.$j.''.$t.']</span>'.$flag2.'
		<div class="postmessage">'.$desp.'</div>';
        $setv = $stats?intval($input):$chmin; 
	    if($othinput == 1){
	   	  $list .= '<div style="width:600px; border-bottom-width: 20px;">
          <span  style="color:red; float: left;">'.$optionarr[0].'('.$chmin.')</span>
          <span  style="color:red; float: right;">'.$optionarr[1].'('.$chmax.')</span>
         </div>
		<div id="idSlider'.$oid.'" class="slider3" '.$boxchk.'>
  	    <div id="idBar'.$oid.'" class="imageBar1"  style="position: absolute;"></div>
  	    '.($stats?'<span id="slider_sp'.$oid.'" style="color: red; font-size: 14px; position: absolute; margin:17px 0px;">'.$setv.'</span>'
  	             :'<span id="slider_sp'.$oid.'" style="color: red; font-size: 14px; position: absolute; top: 17px;">'.$setv.'</span>'
        ).'
  	    <input type="hidden" id ="suboption['.$oid.']" name="suboption['.$oid.']" value="'.$setv.'">
  	    </div>';
	   	  $list .= $stats?'
     	 <script type="text/javascript">
	   	    var chmin = '.$chmin.';
	   	    var chmax = '.$chmax.';
	   	    var setv =  '.$setv.';
	   	    var leftpx =  590/(chmax - chmin)*setv; 
	   	    var ofsleft = getOffsetLeft($("idSlider'.$oid.'"));
	   	    $("idBar'.$oid.'").style.left = (ofsleft + leftpx)+"px"; 
	   	    $("slider_sp'.$oid.'").style.left = $("idBar'.$oid.'").style.left ;
	   	    function getOffsetLeft(o)
					{
					    var left=0;
					    var offsetParent = o;
					    while (offsetParent!=null && offsetParent!=document.body) 
					    {
					        left+=offsetParent.offsetLeft;
					        offsetParent=offsetParent.offsetParent;
					    }
					    return left;
					}
     	  </script>
	   	  ':'
       <script type="text/javascript">
          var sld'.$oid.' = new Slider("idSlider'.$oid.'", "idBar'.$oid.'",{
	      onMove: function(){
	        $("suboption['.$oid.']").value = Math.round(this.GetValue()); 
	        $("slider_sp'.$oid.'").style.left = $("idBar'.$oid.'").style.left;
	        $("slider_sp'.$oid.'").innerHTML = Math.round(this.GetValue());
          }
          });
	      sld'.$oid.'.MinValue = '.$chmin.';
	      sld'.$oid.'.MaxValue = '.$chmax.';
       </script>';

	   }elseif($othinput == 2){
	   	 $chmax = $chmax > 10 ? 10:$chmax;
	   	$list .= '<div style="width:600px; margin:18px;" '.$boxchk.'>
         <span  style="color:red;">'.$optionarr[0].'(1)</span>
         '.($stats?'<script type="text/javascript">Showstar('.$setv.','.$chmax.');</script>'
	   	:'<script type="text/javascript">Showstar('.$oid.','.$chmax.');</script>'
         ).'<span  style="color:red;">'.$optionarr[1].'('.$chmax.')</span>
        </div>';
	   }
	    $list .= '</td></tr>'; 
      break;
	case  9 : 
		  $stats ? $boxchk = '':$boxchk = $boxchk1.'"'; 		   
	  	  $j = lang('plugin/nds_up_ques','tptype');
		  $k = '<div class="d_c d_c'.$othinput.'"><ul>';
		  $imgarr = explode("\n",$keyarray); 
		foreach($optionarr as $id => $value){
			$value = trim($value);
			$inputarr = explode(",",$input);
			foreach($inputarr as $key => $inputs){
			 $inputarr[$key] = trim($inputs);	
			}
			$imgarr2 = explode("|",$imgarr[$id]);
			$imgarr2[1] = empty($imgarr2[1])?$imgarr2[0]:$imgarr2[1];  
 			$k .= '<li> <a target="_blank" href="'.$imgarr2[1].'"><img  border="0" src="'.$imgarr2[0].'"></a>
			<div align="center"> 	       
			<input type="checkbox" name="suboption['.$oid.']['.$i.']" value="'.$value.'" '.$disable.' '.(in_array($value,$inputarr) ? 'checked' : '').' '.$boxchk.'>'.$qselect[$abc].''.$value.'
			</div></li>';
			$abc++;
			$i++;
		}
	    $k .= '</ul></div>';   
		$list= '<tr class="fl_row"><td>'.$flag1.'<h2>'.$nid.'.&nbsp;'.$title.'</h2>&nbsp;<span class="notes">['.$j.''.$t.']</span>'.$flag2.'<div class="postmessage">'.$desp.'</div>'.$k.$pp.'</td></tr>';			
		break;	

	} // switch
	
	
	return $list;
}

function makereport($oid,$title,$desp,$option,$type,$least,$chmin,$chmax,$ndssum,$stats = 1,$data = array(),$keyarray = '',$total = 0,$nid,$ndsabc){
	//$qselect = array();
   	$qselect = array('A. ', 'B. ','C. ','D. ','E. ', 'F. ','G. ','H. ','I. ', 'J. ','K. ','L. ','M. ', 'N. ','O. ','P. ','Q. ', 'R. ','S. ','T. ','U. ', 'V. ','W. ','X. ','Y. ', 'Z. ');
	$list= '';
	$i= 1;
	$b = 0;
	$c = 0;
	$total = $total ? $total:0;
	$j = $type  < 6  ?  ($type  < 4 ? lang('plugin/nds_up_ques','sstype'):lang('plugin/nds_up_ques','mmtype')) : ($type == 9 ? lang('plugin/nds_up_ques','mmtype') :lang('plugin/nds_up_ques','hdtype'));
	$j .= ''.$least != 0 ? lang('plugin/nds_up_ques', 'answerchoose') : lang('plugin/nds_up_ques','answermust');
	$j .= ''.$chmin && in_array($type,array(4,5,9)) ? lang('plugin/nds_up_ques', 'nds_chmins').$chmin.lang('plugin/nds_up_ques', 'nds_js_max2'):'';
	$j .= ''.$chmax && in_array($type,array(4,5,9)) ? lang('plugin/nds_up_ques', 'nds_chmaxs').$chmax.lang('plugin/nds_up_ques', 'nds_js_max2'):'';
	$colors = array('E92725', 'F27B21', 'F2A61F', '5AAF4A', '42C4F5', '0099CC', '3365AE', '2A3591', '592D8E', 'DB3191');
	$optionarr = explode("\n",$option);
	$optlen = count($optionarr);
	if ($optlen > 25 || !$ndsabc ) $qselect = array();
	if($stats == 1){  
		     $k = '';
	       $pp = '<div class="pcht"><div class="postmessage"><div class="box pollpanel"><h4><span>'.lang('plugin/nds_up_ques', 'datas').$total.lang('plugin/nds_up_ques', 'datas1').'</span>&nbsp;</h4><table summary="poll panel" cellspacing="0" cellpadding="0" width="100%">';
	if ($type!=8){ 
	     foreach(explode("\n",$keyarray) as $t){
	    	 $t = trim($t);
	    	 $pc = $total ? intval($data[$t]*100 / $total) : 0;
	    	 $bars = $pc ? $pc : 8;
	    $pp .= '<tr class="fl_nrow"><td class="pvt"><label style="color:#'.$colors[$c].'">'.lang('plugin/nds_up_ques', 'optionNO').$qselect[$b++].'</label>:&nbsp;<label>'.$t.'</label></td><td class="pvts"></td></tr>';
        $pp .= '<tr class="fl_nrow"><td><div class="pbg"><div class="pbr" style="width: '.$bars.'%; background-color:#'.$colors[$c].'"></div></div></td><td>'.$pc.'% <em style="color:#'.$colors[$c++].'">('.($data[$t] ? $data[$t] : 0).')</em></td></tr>';
        if ($c > 9 ) $c = 0;
      }
	 }else{
	 	$pc  = $ndssum/$total/($chmax-$chmin+1)*100;
	 	$pc = round($pc,2);
	 	$bars = $pc ? $pc : 8;
	 	$pp .= '<tr class="fl_nrow"><td class="pvt"><label style="color:#'.$colors[$c].'">'.lang('plugin/nds_up_ques', 'nds_range').'['.$optionarr[0].']'.$chmin.' -- '.$chmax.'['.$optionarr[1].']</label></td></tr>';
        $pp .= '<tr class="fl_nrow"><td><div class="pbg"><div class="pbr" style="width: '.$bars.'%; background-color:#'.$colors[$c].'"></div></div></td><td>'.$ndssum/$total.'<em style="color:#'.$colors[$c].'">('.($ndssum ? $ndssum : 0).'/'.$total.')</em></td></tr>';
    
	 }
         $pp .= '</table><div></div></div>';


		$list= '<tr class="fl_row"><td><h2>'.$nid.'.&nbsp;'.$title.'</h2>&nbsp;<span class="notes">['.$j.']</span><div class="postmessage">'.$desp.'</div>'.$k.$pp.'</td></tr>';
	}
	return $list;
}

function getgz($mark,$strategy){
  $rtarr = array(0,0);
  $min =0;
  $max =0;
  foreach(explode("\n",$strategy) as $value){
  	$gzrow = explode("|",$value);
  	if (!empty($gzrow[0])){
  	  $gzmark = explode("-",$gzrow[0]);
  	  if ($gzmark[0]>=0) $min = $gzmark[0];
  	  if (!empty($gzmark[1])) $max = $gzmark[1];	   
      if ($mark >= min && $mark <= $max) {
   		   $rtarr[0]= $gzrow[1];
   		   $rtarr[1]= str_replace("&amp;","&",$gzrow[2]);
    	  break;    	
  	  }
  	}	 	
  }
 return  $rtarr;    
}

?>