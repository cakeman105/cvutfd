/**
 * AJAX function for checking for existing users
 * @author Joshua David Crofts
 */
function GetUser()
{
    var username = document.getElementById("registerUserId").value;

    var req = new XMLHttpRequest();
    req.open('POST', './php/helpers/AjaxHelper.php', true);
    req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    req.onreadystatechange = function()
    {
        if (req.readyState === 4 && req.status === 200)
        {
            if (req.responseText === "")
            {
                document.getElementById("registerButton").removeAttribute("disabled");
            }
            else
            {
                document.getElementById("registerButton").setAttribute("disabled", "disabled");
                document.getElementById("result").textContent = req.responseText;
            }
        }
    }

    var data = "username=" + encodeURIComponent(username);

    req.send(data);
}

var element = document.getElementById("registerUserId");
element.addEventListener('change', GetUser);