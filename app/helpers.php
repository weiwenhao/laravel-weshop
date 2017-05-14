<?php
//对数组进行升序排列并已,分隔转化为字符串
function sortOrImplode($arr){
    sort($arr, 1);
    return implode(',', $arr);
}
