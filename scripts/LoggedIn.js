/**
 * Ajax for getting whether a user is logged in and displaying forms
 * @note JSbad
 * @param elementId
 * @param type
 * @param elementId2
 */
function RemoveForm(elementId, type, elementId2 = null)
{
    var req = new XMLHttpRequest();
    req.open('POST', './php/helpers/SessionHelper.php', true); //change the path on production!
    req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    var url = new URL(window.location.href);
    var param = url.searchParams.get("id");

    req.onreadystatechange = function()
    {
        if (req.readyState === 4 && req.status === 200)
        {
            if (req.responseText === "false" && type === "film")
                document.getElementById(elementId).remove();
            else if (type === "profile" && req.responseText !== param && param !== null)
            {
                document.getElementById(elementId).remove();
            }

            if (elementId2 != null && req.responseText !== "1" || (param !== "1" && param !== null))
                document.getElementById(elementId2).remove();
        }
    }
    req.send();
}
