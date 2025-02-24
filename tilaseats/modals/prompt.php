<div id=prompt class=modal>
    <div class='formcard modal-content prompt center' style='width:40%'>
        <span class=close id=close onclick = "closeModal()">&times;</span>
        <span class=success></span>
        <span class=error></span>
        <div>
            Do you want to delete <span id=deleteitemtxt></span>?
        </div>
        <div>
            <input id=deleteitem type=hidden value=''>
            <input id=itemsection type=hidden value='<?=$_GET['section']?>'>
            <button onclick="deleteItem('prompt')" class='safe'>Yes</button>
            <button onclick="closeModal()" class='warning'>No</button>
        </div>
    </div>
</div>