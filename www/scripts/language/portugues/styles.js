function loadText()
    {
    var txtLang = document.getElementsByName("txtLang");
    txtLang[0].innerHTML = "Estilos";
    txtLang[1].innerHTML = "Pr&eacute;-Visualizar";
    txtLang[2].innerHTML = "Aplicar para";
    
    var optLang = document.getElementsByName("optLang");
    optLang[0].text = "Texto Selecionado"
    optLang[1].text = "Tag Atual"
    
    document.getElementById("btnCancel").value = "Cancelar";
    document.getElementById("btnApply").value = "Aplicar";
    document.getElementById("btnOk").value = " OK ";
    }
    
function getText(s)
    {
    switch(s)
        {
        case "You're selecting BODY element.":
            return "Voc&ecirc; est&aacute; selecionando o elemento BODY.";
        case "Please select a text.":
            return "Favor selecionar um texto.";
        default:return "";
        }
    }
    
function writeTitle()
    {
    document.write("<title>Estilos</title>")
    }
