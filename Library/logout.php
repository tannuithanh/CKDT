<?php
session_start();
if(isset($_SESSION['link']))
    unset($_SESSION['link']);
if(isset($_SESSION['Name']))
    unset($_SESSION['Name']);
if(isset($_SESSION['idmember']))
    unset($_SESSION['idmember']);
if(isset($_SESSION['LinkCur']))
    unset($_SESSION['LinkCur']);
header("Location: ../Index.php");