<?php
//load author class
require_once (byrneindia\objectoriented\author.php)

use byrneindia\objectoriented\author;

//use the constructor
$robinson = new Author("07f2595c-75d0-11ea-bc55-0242ac130003",
	"13b7ff8a75d011eabc550242ac130003",
	"byrneindia@.edu",
	"deepdive-coders@.edu",
	"2508b78e6df07bd85670289f7a5a86b0eacd45c33d6c33b120221e84051c482bbd23296a95f01340665dcb0969cc00489",
	"robinson",);
echo("Author ID: ");
echo($robinson -> getAuthorId());
echo(" <br>Author Activation Token: ");
echo($robinson>Author Avatar Url: ");
echo($robinson -> getAuthorAvatarUrl());
echo(" <br>Author Email: ");
echo($robinson -> getAuthorEmail());
echo(" <br>Author Hash: ");
echo($robinson -> getAuthorHash());
echo(" <br>Author Username: ");
echo($robinson -> getAuthorUsername());