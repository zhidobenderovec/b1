function confirmDelete() {
    if (confirm('Вы действительно хотите удалить это?'))
    {
        return true;
    }
    else
    {
        //alert("Вы нажали кнопку отмена")
        return false;
    }
}
