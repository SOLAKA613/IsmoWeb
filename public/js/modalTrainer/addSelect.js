var selectionCounter = 1;
var id;

function cloneSelect() {

    idSelect = "float-select" + selectionCounter;
    remscnt = "remScnt" + selectionCounter;
    scntDiv = document.getElementById("float-select");
    $('<div id="' + idSelect + '" class="row select"><a href="#" id="' + remscnt + '">Remove</a></div>').appendTo(scntDiv);
    document.getElementById(idSelect).appendChild(clone("Div"));
    document.getElementById(idSelect).appendChild(clone("Lev"));
    document.getElementById(idSelect).appendChild(clone("Mod"));
    document.getElementById(remscnt).setAttribute("onclick", "removeSelect('" + idSelect + "')");
    document.getElementById("contSelect").value = selectionCounter;
    selectionCounter++;
}


function crateSelects(division, level, module) {
    nb = division.length - 1;
    if (nb > 0) {
        for (i = 1; i <= nb; i++) {
            idSelect = "float-select" + selectionCounter;
            scntDiv = document.getElementById("float-select");
            remscnt = "remScnt" + selectionCounter;
            $('<div id="' + idSelect + '" class="row select"><a href="#" id="' + remscnt + '">Remove</a></div>').appendTo(scntDiv);
            document.getElementById(idSelect).appendChild(clone1("Div", division[i]));
            clone2("Lev", level[i], "Select Level", idSelect);
            clone2("Mod", module[i], "Select Module", idSelect);
            document.getElementById(remscnt).setAttribute("onclick", "removeSelect('" + idSelect + "')");
            document.getElementById("contSelect").value = selectionCounter;
            selectionCounter++;
        }
    }
}


function removeSelect(idSelect) {
    var top = document.getElementById("float-select");
    var nested = document.getElementById(idSelect);
    top.removeChild(nested);
}

function clone(id1) {
    var select = document.getElementById(id1)
    var clone = select.cloneNode(true);
    clone.id = id1 + "" + selectionCounter;
    let enfantDiv = select.children;
    let enfDiv1 = enfantDiv[0].childNodes;
    let enfDiv2 = enfDiv1[1];
    let enfantDivClon = clone.children;
    let enfDivClon1 = enfantDivClon[0].childNodes;
    let enfDivClon2 = enfDivClon1[1];
    var name = enfDiv2.getAttribute("name") + selectionCounter;
    var data = enfDiv2.getAttribute("data-dependent") + selectionCounter;
    id = name.charAt(0).toUpperCase() + name.slice(1);
    enfDivClon2.id = id;
    enfDivClon2.setAttribute("onchange", "sendData(" + id + ")");
    enfDivClon2.setAttribute("name", name);
    enfDivClon2.setAttribute("data-dependent", data);
    return clone;
}




function clone1(id1, division) {
    var select = document.getElementById(id1)
    var clone = select.cloneNode(true);
    clone.id = id1 + "" + selectionCounter;
    let enfantDiv = select.children;
    let enfDiv1 = enfantDiv[0].childNodes;
    let enfDiv2 = enfDiv1[1];
    let enfantDivClon = clone.children;
    let enfDivClon1 = enfantDivClon[0].childNodes;
    let enfDivClon2 = enfDivClon1[1];
    for (var i = 0; i < enfDivClon2.options.length; i++) {
        if (enfDivClon2.options[i].text === division) {
            enfDivClon2.selectedIndex = i;
            break;
        }
    }
    var name = enfDiv2.getAttribute("name") + selectionCounter;
    var data = enfDiv2.getAttribute("data-dependent") + selectionCounter;
    id = name.charAt(0).toUpperCase() + name.slice(1);
    enfDivClon2.id = id;
    enfDivClon2.setAttribute("onchange", "sendData(" + id + ")");
    enfDivClon2.setAttribute("name", name);
    enfDivClon2.setAttribute("data-dependent", data);
    return clone;
}

function clone2(idNoeud, levMod, text, parent) {
    var name = $('#' + idNoeud).children(".form-floating").children("select").attr("name") + selectionCounter;
    var data_dependent = $('#' + idNoeud).children(".form-floating").children("select").attr("data-dependent") + selectionCounter;
    id = name.charAt(0).toUpperCase() + name.slice(1);

    var noeudParent = $('#' + idNoeud).clone();
    noeudParent.attr('id', idNoeud + "" + selectionCounter);
    var select = noeudParent.children(".form-floating").children("select");
    select.attr('name', name).attr('id', id).attr('data-dependent', data_dependent);
    select.empty().append($("<option></option>").attr("value", "").text(text));
    select.append($("<option selected></option>").attr("value", levMod).text(levMod));
    noeudParent.appendTo($('#' + parent));
}


function sendData(id) {
    var select = id.getAttribute("id");
    value = id.value;
    var dependent = id.getAttribute('data-dependent');
    var _token = $('input[name="_token"]').val();
    $.ajax({
        url: "../moduleTrainerController/fetch",
        method: "POST",
        data: { select: select, value: value, _token: _token, dependent: dependent },
        success: function(result) {
            $('#' + dependent).html(result);
        },
        error: function(data) {
            alert("Internal Server Error");
        }
    });
}