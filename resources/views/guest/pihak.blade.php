<div class="table-responsive">
    <table class="table" id="table-terlibat">
        <tr>
            <td></td>
            <td>
                <input type="text" name="pihaks[nama][]" class="form-control" placeholder="Nama" required>
            </td>
            <td width="50%">
                <input type="text" name="pihaks[jabatan][]" class="form-control" placeholder="Jabatan" required>
            </td>
        </tr>
    </table>
</div>
<button type="button" class="btn-add-pihak btn btn-primary btn-sm btn-block" onclick="addRow()"><i class="ti-plus"></i></button>
<script>
function addRow()
{
    var table = document.getElementById('table-terlibat');

    var rowCount = table.rows.length;
    var row = table.insertRow(rowCount);
    row.id = "row_"+rowCount

    var colCount = table.rows[0].cells.length;
    var newcell	= row.insertCell(0);
    newcell.innerHTML = '<button class="btn btn-sm btn-danger" type="button" onclick="deleteRow('+rowCount+')"><i class="ti-close"></i></button>'

    for(var i=1; i<colCount; i++) {

        var newcell	= row.insertCell(i);

        newcell.innerHTML = table.rows[0].cells[i].innerHTML;
        //alert(newcell.childNodes);
        switch(newcell.childNodes[0].type) {
            case "text":
                    newcell.childNodes[0].value = "";
                    break;
            case "checkbox":
                    newcell.childNodes[0].checked = false;
                    break;
            case "select-one":
                    newcell.childNodes[0].selectedIndex = 0;
                    break;
        }
    }
}

function deleteRow(row_id) {
    document.getElementById('row_'+row_id).remove()
}
</script>