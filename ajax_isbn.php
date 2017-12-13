<!DOCTYPE html>
<html>
<body>

<form action="">
ISBN-10: <input type="text" id="isbn10" onkeyup="getBookXML(this.value)"><br>
Title: <input type="text" id="title"><br>
<span id="fillThis"></span><br>
<span id="url"></span>
</form>

<script>
function getBookXML(str) {
	var xhttp, xmlDoc, txt, x, i;

	if(str.length < 10){
		document.getElementById("title").value = "Invalid ISBN";
		document.getElementById("fillThis").innerHTML = "Invalid ISBN";
		document.getElementById("url").innerHTML = "... finish ISBN field ...";
		
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
		document.getElementById("url").innerHTML = "isbn_api.php?q=" + str;
		//make the fields read only
		document.getElementById("title").readOnly = true;
	}
	xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function()
	{
		if(this.readyState == 4 && this.status == 200) //checks for response and OK status
		{
			xmlDoc = this.responseXML;
			x = xmlDoc.getElementsByTagName("title");
			txt = "";

			for (i = 0; i < x.length; i++) {
				txt = txt + x[i].childNodes[0].nodeValue;
			}

			document.getElementById("title").value = txt;
			document.getElementById("fillThis").innerHTML = txt;
			
			//If the title value is empty, ie. error or nonexistent ISBN or book not in the ISBNapi database, 
			//then make the field writable to allow the user to enter their own information manually
			if(document.getElementById("title").value == "")
			{
						document.getElementById("title").readOnly = false;
			}
		}
	};

	xhttp.open("GET", "isbn_api.php?q=" + str, true); //AJAX opens the page dynamically
	xhttp.send();
}

</script>
</body>
</html>