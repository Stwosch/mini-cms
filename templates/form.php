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
        <header class="main-header bg-primary">
            <h1>Control Form</h1>
            <p>Choose what you want to do with your tiles</p>
            <button type="button" class="btn btn-success btn-lg btn-form-state" id="add-state">
                Add
                 <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
            </button>
            <button type="button" class="btn btn-warning btn-lg btn-form-state" id="edit-state">
                Edit
                <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
            </button>
            <button type="button" class="btn btn-danger btn-lg btn-form-state" id="remove-state"> 
                Remove
                <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
            </button>
        </header>
        <div class="statement error">%errors%</div>
        <div class="statement success">%success%</div>
        <form action="add-tile" method="post" enctype="multipart/form-data" class="is-hidden" id="add-tile-form">
            <h2>Add new tile</h2>
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
            <input type="submit" value="Submit" class="btn btn-default" name="add-tile">
        </form>
        <div id="edit-tile-form" class="is-hidden">
            <h2>Edit your tiles (double-click to edit)</h2>
            <table class="table table-hover">
                <thead>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Type</th>
                    <th>Img</th>
                    <th>Img alt</th>
                    <th>Date</th>
                </thead>
                <tbody>
                    %tableEdit%
                </tbody>
            </table>
        </div>
        <div id="remove-tile-form" class="is-hidden">
            <h2>Remove your tiles (double-click to remove)</h2>
            <table class="table table-hover">
                <thead>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Type</th>
                    <th>Img</th>
                    <th>Img alt</th>
                    <th>Date</th>
                </thead>
                <tbody>
                    %tableRemove%
                </tbody>
            </table>
        </div>
	</main>
    <script src="assets/js/form.js"></script>
</body>
</html>';

