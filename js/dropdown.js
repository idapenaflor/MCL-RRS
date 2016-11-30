function aDrop()
{
	document.getElementById("Dept").length = '0';

		//Call mainMenu the main dropdown menu
        var uType = document.getElementById('uType');

			if (uType.value == "Staff" || uType.value == "Dean")
			{
				 document.getElementById("Dept").options[0]=new Option("CAS","CAS");
				 document.getElementById("Dept").options[1]=new Option("CCIS","CCIS");
				 document.getElementById("Dept").options[2]=new Option("CMET","CMET");
				 document.getElementById("Dept").options[3]=new Option("ETYCB","ETYCB");
				 document.getElementById("Dept").options[4]=new Option("IEXCEL","IEXCEL");
				 document.getElementById("Dept").options[5]=new Option("MITL","MITL");
			}
			else if (uType.value == "CDMO" || uType.value == "LMO")
			{
				document.getElementById("Dept").options[0]=new Option("Admin","Admin");
      }

}
function ValidateSelect()
    {
      var from = document.getElementById("cmbFrom").value;
      var to = document.getElementById("cmbTo").value;
      if (document.getElementById("cmbFrom").value == 9)
      {
        document.getElementById("cmbTo").value = 10;
        document.getElementById("cmbTo").disabled = true;
      }
      else
      {
        if(from > to)
          { $('#valid2').innerHtml('Invalid time.'); }
        else
          { $('#valid2').slideDown().html('<span id="success"></span>');}
        document.getElementById("cmbTo").disabled = false;
      }
    }  
function swapContent(cv)
    {
      $("#myDiv").html("Loading...");

      $.post(cv, {contentVar: cv}, function(data){
        $("#myDiv").html(data).show();
      })
    }