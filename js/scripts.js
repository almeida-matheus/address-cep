//== MODAL ==//
const Modal = {
    open(){
        document
            .querySelector('.modal1-overlay')
            .classList
            .add('active')

    },
    close(){
        document
            .querySelector('.modal1-overlay')
            .classList
            .remove('active')
    }
}