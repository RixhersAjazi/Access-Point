$(document).ready(function() {
    $('.display').dataTable({
	"bJQueryUI": true,
	"bSort": false,
	 "aaSorting": [],
	"sPaginationType": "full_numbers",
	"sDom": '<"H"lfTr>t<"F"ip>',
	"iDisplayLength": 50,
	"aLengthMenu": [10,20,30,40,50,60,70,80,90,100,150,200],
	"oTableTools": {
	    "sSwfPath": "/javascript/js/copy_csv_xls_pdf.swf",
	    "aButtons": [
		"print", "csv", "pdf"
	    ]
	}
    });
});