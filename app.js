class UI {
    constructor() {
        this.amount = document.querySelector('.expense_amount')
        this.name = document.querySelector('.expense_name')
        this.err = document.querySelector('.errMessage')
    }

    submitForm = () => {
        const inp_amount = this.amount.value
        const inp_name = this.name.value
        if (
            inp_amount === 0 ||
            inp_amount === '' ||
            inp_name === 0 ||
            inp_name === ''
        ) {
            this.err.classList.add('errMessage_show')
            this.err.innerHTML = `<p>Value cannot be empty or zero</p>`
            setTimeout(() => {
                this.err.classList.remove('errMessage_show')
            }, 3000)
        }
    }
}

const eventListeners = () => {
    const formSubmit = document.querySelector('.expense-form_main')
    const header = document.getElementById('myDIV')
    const btns = header.getElementsByClassName('btn')
    const table = document.getElementById('mytab')

    const ui = new UI()

    formSubmit.addEventListener('submit', e => {
        e.preventDefault()
        ui.submitForm()
    })

    for (var i = 0; i < btns.length; i++) {
        btns[i].addEventListener('click', function() {
            var current = document.getElementsByClassName('active')
            current[0].className = current[0].className.replace(' active', '')
            this.className += ' active'
        })
    }

    for (var i = 0, row; (row = table.rows[i]); i++) {
        //iterate through rows
        //rows would be accessed using the "row" variable assigned in the for loop
        console.log(row.length)
    }
    
}

document.addEventListener('DOMContentLoaded', () => {
    eventListeners()
})
