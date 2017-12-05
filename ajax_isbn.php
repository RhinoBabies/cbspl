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
		return;
	}
	else
		document.getElementById("url").innerHTML = "isbn_api.php?q=" + str;

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
		}
	};

	xhttp.open("GET", "isbn_api.php?q=" + str, true); //AJAX opens the page dynamically
	xhttp.send();
}

</script>
</body>
</html>