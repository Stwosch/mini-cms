<?php

$template = '
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width">
	<title>Zadanie 2 Form</title>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:500">
	<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="assets/css/form.css">
</head>
<body>
	<main class="container">

        <h2>Edit your [%id%] tile</h2>
       <form action="edit-tile" method="post" enctype="multipart/form-data">
            <input name="id" type="hidden" value="%id%">
            <div class="form-group">
                <label for="title">Title: </label>
                <input type="text" class="form-control" id="title" placeholder="Title" name="title">
            </div>
            <div class="form-group">
                <label for="type">Type: </label>
                <select class="form-control" id="type" name="type">
                    <option value="norm">Normal</option>
                    <option value="main">Main</option>
                </select>
            </div>
            <div class="form-group">
                <label for="img">Select image to upload: </label>
                <input type="file" name="img" id="img">
            </div>
            <div class="form-group">
                <label for="img_alt">Image alt: </label>
                <input type="text" class="form-control" id="img_alt" placeholder="Image alt" name="img_alt">
            </div>
            <div class="form-group">
                <label for="date">Date: </label>
                <input id="date" type="date" name="date">
            </div>
            <input type="submit" value="Submit" class="btn btn-default" name="edit-tile">
            <a href="form" class="btn btn-default">Go Back</a>
        </form
	</main>
</body>
</html>';