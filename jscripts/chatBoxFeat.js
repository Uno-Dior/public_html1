function toggleSections(section) {
    // Toggle the display of the user and chat box sections
    var usersSection = document.querySelector('.users');
    var chatBoxSection = document.querySelector('.chatBox');

    if (section === 'users') {
        usersSection.style.display = 'flex';
        chatBoxSection.style.display = 'none';
    } else if (section === 'chatBox') {
        usersSection.style.display = 'none';
        chatBoxSection.style.display = 'flex';
    }
}