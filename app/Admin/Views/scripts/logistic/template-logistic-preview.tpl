<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title></title>
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="Cache-Control" content="public">
<style type="text/css">
body
{
  background-color: #ffffff;
  padding: 0px;
  margin: 0px;
  text-align:center;
}
table, td, div {
    font: normal 14px  Verdana, "Times New Roman", Times, serif;
    font-weight: bolder;
}
.table_box
{
  table-layout: fixed;
  text-align:center;
}
.display_no
{
  display:none;
}
</style>
</head>
<body id="print">
<img id="image">
<!--打印区 start-->


<!--打印区 end-->
</body>
</html>

<script type="text/javascript">
var global_value;
var image_width;
var image_height;
<!--
onload = function()
{
    global_value = window.opener.document.getElementById('global_value').value;
    global_image = window.opener.document.getElementById('global_image').value;
    if ( global_value == '' ) {
        alert('没有标签配置信息！');
        return false;
    }
    if ( global_image == '' ) {
        alert('没有打印单！');
        return false;
    }
    
    document.getElementById('image').src = global_image;
    image_width = document.getElementById('image').width;
    image_height = document.getElementById('image').height;
    document.getElementById('image').style.display = 'none';
    _create_shipping_print();
}

/**
 * 创建快递单打印内容
 */
function _create_shipping_print()
{
  //创建快递单
  var print_bg = _create_print_bg();

  //创建文本
  var config_lable = global_value;

  var lable = config_lable.split("||,||");

  if (lable.length <= 0)
  {
    return false; //未设置打印内容
  }

  for (var i = 0; i < lable.length; i++)
  {
    //获取标签参数
    var text = lable[i].split(",");
    if (text.length <= 0 || text[0] == null || typeof(text[0]) == "undefined" || text[0] == '')
    {
      continue;
    }

    text[4] -= 10;
    text[5] -= 10;

    _create_text_box(print_bg, text[0], text[1], text[2], text[3], text[4], text[5]);
  }
}

/**
 * 创建快递单背景
 */
function _create_print_bg()
{
  var print_bg = document.createElement('div');

  print_bg.setAttribute('id', 'print_bg');

  var print = document.getElementById('print');

  print.appendChild(print_bg);
  
  print_bg.style.background = 'url(' + global_image + ') no-repeat';
  
  //设置快递单样式
  print_bg.style.width = image_width + 'px';
  print_bg.style.height = image_height + 'px';
  print_bg.style.zIndex = 1;
  print_bg.style.border = "solid 1px #FFF";
  print_bg.style.padding = "0";
  print_bg.style.position = "relative";
  print_bg.style.margin = "0";
  
  return print_bg;
}

/**
 * 创建快递单文本
 */
function _create_text_box(print_bg, id, text_content, text_width, text_height, x, y)
{
  var text_box = document.createElement('div');

  //设置属性
  text_box.setAttribute('id', id);

  print_bg.appendChild(text_box);

  //设置样式
  text_box.style.width = text_width + "px";
  text_box.style.height = text_height + "px";
  text_box.style.border = "0";
  text_box.style.padding = "0";
  text_box.style.margin = "0 auto";

  text_box.style.position = "absolute";
  text_box.style.top = y + "px";
  text_box.style.left = x + "px";

  text_box.style.wordBreak = 'break-all'; //内容自动换行 严格断字
  text_box.style.textAlign = 'left';

  //赋值
  text_box.innerHTML = text_content;

  return true;
}
//-->


</script>
