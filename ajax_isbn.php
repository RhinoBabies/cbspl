<!DOCTYPE html>
<html>
<body>

<?php
	if($_SERVER["REQUEST_METHOD"] == "POST")
		echo "ISBN-10: " . $_POST['isbn10'] . "<br>
		TITLE: " . $_POST['title'] . "<br>
		AUTHOR: " . $_POST['author'] . "<br>";
?>

<form action="" method="post">
ISBN-10: <input type="text" name="isbn10" id="isbn10" onkeyup="getBookXML(this.value)" onblur="getBookXML(this.value)"><br>
Title: <input type="text" name="title" id="title"><br>
Author: <input type="text" name="author" id="author"><br>
<span id="titleSpan"></span><br>
<span id="authorSpan"></span><br>
<span id="comment"></span><br>
<input type="submit" value="Confirm">
</form>

<script>
function getBookXML(str) {
	var xhttp, xmlDoc, txt, title, i, author;

	if(str.length < 10){
		document.getElementById("title").value = "";
		//document.getElementById("fillThis").innerHTML = "Invalid ISBN";
		document.getElementById("comment").innerHTML = "Please finish filling in the ISBN field ...";
		
		//if the string is less than 10 characters, for whatever reason, make the fields writable
		document.getElementById("title").readOnly = false;
		
		return;
	}
	else if(str.length > 10) //if the string is more than 10 characters, make the fields writable
	{
		document.getElementById("title").readOnly = false;
	}
	else
	{
		//document.getElementById("url").innerHTML = "isbn_api.php?q=" + str;
		//make the fields read only
		document.getElementById("title").readOnly = true;
	}

	xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function()
	{
		if(this.readyState == 4 && this.status == 200) //checks for response and OK status
		{
			xmlDoc = this.responseXML;

			//grab title
			title = xmlDoc.getElementsByTagName("title");
			txt = "";

			txt = txt + title[0].childNodes[0].nodeValue;


			document.getElementById("title").value = txt;
			document.getElementById("titleSpan").innerHTML = txt;

			//If the title value is empty, ie. error or nonexistent ISBN or book not in the ISBNapi database, 
			//then make the field writable to allow the user to enter their own information manually
			if(document.getElementById("title").value == "")
			{
				document.getElementById("title").readOnly = false;
			}

			//grab author
			author = xmlDoc.getElementsByTagName("author_data");
			txt = "";

			txt = txt + author[0].childNodes[3].childNodes[0].nodeValue;

			document.getElementById("author").value = txt;
			document.getElementById("authorSpan").innerHTML = txt;
			
			if(document.getElementById("author").value == "")
			{
				document.getElementById("author").readOnly = false;
			}
		}
	};

	xhttp.open("GET", "isbn_api.php?q=" + str, true); //AJAX opens the page dynamically
	xhttp.send();
}

</script>
</body>
</html>