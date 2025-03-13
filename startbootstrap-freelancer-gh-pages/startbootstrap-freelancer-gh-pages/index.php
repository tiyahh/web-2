<?php
require_once("function/CallPage.php");
CallPage("header");
CallPage("navbar");
if (isset($_GET['page'])) {
    CallPage($_GET['page']);
} else {
    CallPage("home");

}
CallPage("footer");

?>