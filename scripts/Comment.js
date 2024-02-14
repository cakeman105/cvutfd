function CheckComment()
{
    var content = document.getElementById("commentContentId").value
    if (content.trim() === "" && content.length < 256)
    {
        document.getElementById("commentErrorId").textContent = "Komentář nemůže být prázdný!";
        document.getElementById("commentButton").setAttribute("disabled", "");
    }
    else if (content.length >= 256)
    {
        document.getElementById("commentErrorId").textContent = "Komentář je příliš dlouhý!";
        document.getElementById("commentButton").setAttribute("disabled", "");
    }
    else
    {
        document.getElementById("commentErrorId").textContent = "";
        document.getElementById("commentButton").removeAttribute("disabled");
    }
}

document.getElementById("commentContentId").addEventListener("change", CheckComment);