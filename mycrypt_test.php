<?Php
if(function_exists('mcrypt_create_iv')){
echo "<br>mcrypt_create_iv function support is available ";
}else{
echo "<br>mcrypt_create_iv function support is NOT available ";
}

if (extension_loaded('mcrypt')) {
echo "<br>mcrypt support is loaded ";
}else{
echo "<br>mcrypt support is NOT loaded ";
}
?>
