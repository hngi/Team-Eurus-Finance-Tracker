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

    const ui = new UI()

    formSubmit.addEventListener('submit', e => {
        e.preventDefault()
        ui.submitForm()
    })
}

document.addEventListener('DOMContentLoaded', () => {
    eventListeners()
})
