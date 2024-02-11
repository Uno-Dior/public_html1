const toggleBtn = document.querySelector('.toggle_btn')
    const toggle_BtnIcon = document.querySelector('.toggle_btn a')
    const dropDownMenu = document.querySelector('.dropdown_menu')

    toggleBtn.onclick = function () {
        dropDownMenu.classList.toggle('open')
        const isOpen = dropDownMenu.classList.contains('open')

        toggle_BtnIcon.classList = isOpen
        ? 'btn_setting'
        : 'btn_setting'
    }