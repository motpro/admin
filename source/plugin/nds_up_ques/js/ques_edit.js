 function deleteRow(input1)
{
     var td1=input1.parentNode;
     var tr1=td1.parentNode;
     var tindex=tr1.rowIndex;
     document.getElementById("quesbody").deleteRow(tindex);
	 node--; 
}
  function addRow(isbody){
     var tableObj=document.getElementById(isbody);
  	 var newRowObj=tableObj.insertRow(tableObj.rows.length);
     var newColName=newRowObj.insertCell(newRowObj.cells.length);
     //var newColtd=newRowObj.insertCell(newRowObj.cells.length);
  	  newRowObj.height ="118";
	 //newRowObj.colSpan ="2";
	 newColName.innerHTML =document.getElementById("quesbodyhidden").innerHTML;
	 node++;
  }
  
  function doShow(ck,tk)
{  
  var a = document.getElementById(ck);
  var b = document.getElementById(tk);
  if(a.checked){
         b.style.display="inline";
  }else{
	     b.style.display ="none";
  }
}


var getElementsByName2 = function(tag, name){
    returns = new Array();
    var e = document.getElementsByTagName(tag);
    for(var i = 0; i < e.length; i++){
        if(e[i].getAttribute("name") == name){
            returns[returns.length] = e[i];
        }
    }
    return returns;
}
function NDSCheckAll(delid){
 var ck = document.getElementsByName(delid);
 var cb = document.getElementsByName("chkall");
	for(i=0;i<ck.length;i++){
		ck[i].checked = cb[0].checked;
	}
}