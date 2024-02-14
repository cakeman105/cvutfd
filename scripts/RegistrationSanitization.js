function CheckPasswordMatch(pass1, pass2, messageId, button)
{
    let pass= document.getElementById(pass1);
    let repeat = document.getElementById(pass2);

    if (pass.value !== repeat.value)
    {
        document.getElementById(messageId).textContent = "Hesla se neshodují!";
        document.getElementById(button).setAttribute("disabled", "disabled");
    }
    else
    {
        document.getElementById(messageId).textContent = "";
        document.getElementById(button).removeAttribute("disabled");
    }
}

function IsFieldEmptyOrExceedsMax(elementId, displayElementId, button)
{
    let element = document.getElementById(elementId);
    if (element.value.trim() === "" && element.value.length < 256)
    {
        document.getElementById(displayElementId).textContent = "Pole nesmí být prázdné!";
        document.getElementById(button).setAttribute("disabled", "disabled");
    }
    else if (element.value.length >= 256)
    {
        document.getElementById(displayElementId).textContent = "Popis je příliš dlouhý! Max 256 znaků";
        document.getElementById(button).setAttribute("disabled", "disabled");
    }
    else
    {
        document.getElementById(displayElementId).textContent = "";
        document.getElementById(button).removeAttribute("disabled");
    }
}

/**
 * Init for login form
 */
function InitLogin() {
    document.getElementById("registerPass").addEventListener("change", function () {CheckPasswordMatch(this.id, "repeatPass", "repeatPassError", "registerButton")})
    document.getElementById("repeatPass").addEventListener("change", function () {CheckPasswordMatch("registerPass", this.id, "repeatPassError", "registerButton")})
    document.getElementById("registerNameId").addEventListener("change", function () {
        IsFieldEmptyOrExceedsMax(this.id, "firstNameError", "registerButton")
    });
    document.getElementById("registerSurnameId").addEventListener("change", function () {
        IsFieldEmptyOrExceedsMax(this.id, "lastNameError", "registerButton")
    });
    document.getElementById("registerUserId").addEventListener("change", function () {
        IsFieldEmptyOrExceedsMax(this.id, "result", "registerButton")
    });
    document.getElementById("loginUserId").addEventListener("change", function () {
        IsFieldEmptyOrExceedsMax(this.id, "usernameError", "loginButton")
    });
    document.getElementById("loginPassId").addEventListener("change", function () {
        IsFieldEmptyOrExceedsMax(this.id, "passwordError", "loginButton")
    });
}

function InitProfile()
{
    document.getElementById("passId").addEventListener("change", function () {CheckPasswordMatch(this.id, "repeatPassId", "passwordError", "profileButton")});
    document.getElementById("repeatPassId").addEventListener("change", function () {CheckPasswordMatch("passId", this.id, "passwordError", "profileButton")});
    document.getElementById("descriptionId").addEventListener("change", function () {
        IsFieldEmptyOrExceedsMax(this.id, "descriptionError", "profileButton")})
}

function InitAdmin()
{
    document.getElementById("filmNameId").addEventListener("change", function () {IsFieldEmptyOrExceedsMax(this.id, "filmNameError", "filmSubmitButton")})
    document.getElementById("filmDescriptionId").addEventListener("change", function () {IsFieldEmptyOrExceedsMax(this.id, "filmDescriptionError", "filmSubmitButton")})
    document.getElementById("filmposterId").addEventListener("change", function () {IsFieldEmptyOrExceedsMax(this.id, "filmPosterError", "filmSubmitButton")})
}
