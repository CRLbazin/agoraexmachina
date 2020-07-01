$(document).ready(function ()
{
	$('[data-toggle=deleteConfirmation]').confirmation({
		rootSelector: '[data-toggle=deleteConfirmation]',
		title: 'Etes-vous sûr ?',
		btnOkLabel: 'Oui',
		btnCancelLabel: 'Non',
		btnOkClass: 'btn btn-sm btn-danger'
	});

	$('[data-toggle="tooltip"]').tooltip();

	$('textarea.ckeditor').ckeditor();


});


function searching()
{
	var url = updateURLParameter(window.location.href, "search", $('#search').val());
	window.location.href = url;
	return false;
}

function viewing(queryView)
{
	var url = updateURLParameter(window.location.href, "view", queryView);
	window.location.href = url;
	return false;
}


/**
 * http://stackoverflow.com/a/10997390/11236
 */
function updateURLParameter(url, param, paramVal)
{
	url = url.replace("#", "");
    var newAdditionalURL = "";
    var tempArray = url.split("?");
    var baseURL = tempArray[0];
    var additionalURL = tempArray[1];
    var temp = "";
    if (additionalURL) {
        tempArray = additionalURL.split("&");
        for (var i=0; i<tempArray.length; i++){
            if(tempArray[i].split('=')[0] != param){
                newAdditionalURL += temp + tempArray[i];
                temp = "&";
            }
        }
    }

    var rows_txt = temp + "" + param + "=" + paramVal;
    return baseURL + "?" + newAdditionalURL + rows_txt;
}