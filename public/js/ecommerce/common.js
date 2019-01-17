var lba = document.getElementsByClassName("social-share")

function myPopup() {
    window.open(this.href, 'mywin',
            'left=20,top=20,width=500,height=500,toolbar=1,resizable=0');
    event.preventDefault();
    return false;
}

for (var i = 0; i < lba.length; i++) {
    lba[i].addEventListener("click", myPopup, false);
}