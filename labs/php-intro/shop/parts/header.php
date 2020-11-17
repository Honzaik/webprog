<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo $title ?></title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<div id="root">
    <header>
        <h1>Planet Express</h1>
    </header>

    <nav id="categories">
        <ul>
            <li><a href="?page=catalog">Books</a></li>
            <li><a href="?page=catalog">Music</a></li>
        </ul>
    </nav>

    <aside id="cart">
        <h3>Shopping cart</h3>
        <p>Items: 0</p>
        <p><a href="?page=cart">Go to cart</a></p>
    </aside>

    <article id="content">