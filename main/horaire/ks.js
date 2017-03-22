function daty(id,oldcolor){
  if(document.myform.elements["g" + id].value=="")
  {
    SelectNum(id);
  }else{
    deSelectNum(id,oldcolor);
  }
}

function SelectNum(id){
  document.getElementById(id).style.backgroundColor='#FFDF62';
  document.myform.elements["g" + id].value=id;
}

function deSelectNum(id,oldcolor){
  document.getElementById(id).style.backgroundColor=oldcolor;
  document.myform.elements["g" + id].value="";
}
