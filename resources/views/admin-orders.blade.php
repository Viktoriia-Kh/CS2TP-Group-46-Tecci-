<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Tecci | Admin Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- Shared Admin CSS -->
  <link rel="stylesheet" href="TP2_Admin_Common.css">
  <link rel="stylesheet" href="TP2_Admin_Orders.css">
  <!--Google Font-->
  <link href="https://fonts.googleapis.com/css?family=Signika" rel="stylesheet" />
  <!--Font Awesome for Icons-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
  
</head>

<body>

<!--HEADER (REUSABLE)-->
<header class="main-header">
    <div class="container nav-container">
        
    <!--Logo-->
    <a href="TP2_Home.html" class="logo">
        <!--Using this will make the Logo clickable and takes the user to the Home Page-->
        <img src="https://i.ibb.co/8tB48xb/Logo.png" alt="Tecci logo">
        <span class="logo-text">TECCI</span> <!--span is an inline element used for short text-->
    </a>
    
    <!--ADMIN HEADER CONTROLS (MENU + SEARCH)-->
    <div class="admin-header-controls">
        <button class="menu-btn" id="menuBtn" type="button" aria-label="Toggle sidebar">
            <!--id="menuBtn" connects to the JS, for it to work-->
            <i class="fa-solid fa-bars"></i> <!--fa-bars is a Menu Icon linked from Font Awesome-->
        </button>
        
        <div class="search-wrap"> <!--This is a wrapper for styling purpose of the Search Bar-->
            <!--fa-magnifying-glass is a Magnifying Glass Icon linked from Font Awesome-->
            <i class="fa-solid fa-magnifying-glass"></i> <!--This creates a Magnifying Glass Icon which is just purely visual for now-->
            <input type="text" placeholder="Search" aria-label="Search (visual only)">
        </div>
    </div>