<?php
session_start();
echo isset($_SESSION['user']) ? "logged" : "guest";